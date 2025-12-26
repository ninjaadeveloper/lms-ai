<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    // ✅ List (admin: all, trainer: own)
    public function index(Request $request)
    {
        $q = Quiz::query()->with('course')->orderByDesc('id');

        // trainer only: show own created quizzes
        if (auth()->user()->role === 'trainer') {
            $q->where('created_by', auth()->id());
        }

        if ($request->filled('course_id')) {
            $q->where('course_id', $request->course_id);
        }

        $quizzes = $q->paginate(20)->withQueryString();

        // dropdown courses
        $coursesQuery = Course::orderByDesc('id')->select(['id', 'title']);

        // trainer only: only his courses
        if (auth()->user()->role === 'trainer') {
            if (\Schema::hasColumn('courses', 'trainer_id')) {
                $coursesQuery->where('trainer_id', auth()->id());
            }
        }

        $courses = $coursesQuery->get();

        $viewPrefix = auth()->user()->role === 'trainer' ? 'trainer' : 'admin';
        return view($viewPrefix . '.quizzes.index', compact('quizzes', 'courses'));
    }

    // ✅ /admin/quizzes/create  OR /trainer/quizzes/create  => Select Course Page
    public function create()
    {
        $coursesQuery = Course::orderByDesc('id')->select(['id', 'title']);

        if (auth()->user()->role === 'trainer') {
            if (\Schema::hasColumn('courses', 'trainer_id')) {
                $coursesQuery->where('trainer_id', auth()->id());
            }
        }

        $courses = $coursesQuery->get();
        $viewPrefix = auth()->user()->role === 'trainer' ? 'trainer' : 'admin';
        return view($viewPrefix . '.quizzes.select-course', compact('courses'));
    }

    // ✅ /admin/courses/{course}/quizzes/create  => Generator UI
    public function createForCourse(Course $course)
    {
        $this->authorizeTrainerCourse($course);

        $viewPrefix = auth()->user()->role === 'trainer' ? 'trainer' : 'admin';
        return view($viewPrefix . '.quizzes.create', compact('course'));
    }

    // ✅ AI generate endpoint
    public function generate(Request $request, Course $course)
    {
        $this->authorizeTrainerCourse($course);

        $request->validate([
            'topic' => ['required', 'string', 'max:255'],
            'count' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        [$mcqs, $debug] = $this->generateMcqsWithAiDebug($course, $request->topic, (int) $request->count);

        $normalized = [];
        foreach ($mcqs as $m) {
            if (empty($m['question']) || empty($m['options']) || empty($m['answer']))
                continue;
            $opts = $m['options'];
            $normalized[] = [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'question' => trim($m['question']),
                'A' => trim($opts['A'] ?? ''),
                'B' => trim($opts['B'] ?? ''),
                'C' => trim($opts['C'] ?? ''),
                'D' => trim($opts['D'] ?? ''),
                'answer' => strtoupper(trim($m['answer'])),
            ];
        }

        return response()->json([
            'ok' => true,
            'items' => $normalized,
            'debug' => $debug, // 👈 now console me show hoga
        ]);
    }


    private function generateMcqsWithAiDebug(Course $course, string $topic, int $count): array
    {
        $prompt = $this->buildPrompt($course, $topic, $count);

        // ✅ Reuse callAi() which uses v1 + fallback model pick
        $resp = $this->callAi($prompt);

        $debug = [
            'http_ok' => $resp['ok'] ?? false,
            'status' => $resp['status'] ?? null,
            'error' => $resp['error'] ?? null,
            'model' => $resp['model'] ?? null,
            'picked_model' => $resp['picked_model'] ?? null,
            'raw_text_preview' => null,
            'extracted_json_preview' => null,
            'json_decode_error' => null,
        ];

        if (!($resp['ok'] ?? false)) {
            // model error / key issue etc
            return [[], $debug];
        }

        $text = $resp['text'] ?? '';
        $debug['raw_text_preview'] = substr($text, 0, 1200);

        // ✅ Extract JSON array from response
        $jsonArray = null;
        if (preg_match('/\[[\s\S]*\]/', $text, $m)) {
            $jsonArray = $m[0];
        }

        $debug['extracted_json_preview'] = $jsonArray ? substr($jsonArray, 0, 1200) : null;

        if (!$jsonArray) {
            $debug['error'] = 'No JSON array found in model output';
            return [[], $debug];
        }

        $data = json_decode($jsonArray, true);
        if (!is_array($data)) {
            $debug['json_decode_error'] = json_last_error_msg();
            $debug['error'] = 'JSON decode failed';
            return [[], $debug];
        }

        return [$data, $debug];
    }





    // ✅ Save selected questions
    public function store(Request $request, Course $course)
    {
        $this->authorizeTrainerCourse($course);

        // ✅ hidden input JSON -> array
        if (is_string($request->input('selected'))) {
            $decoded = json_decode($request->input('selected'), true);
            $request->merge(['selected' => is_array($decoded) ? $decoded : []]);
        }

        $request->validate([
            'topic' => ['required', 'string', 'max:255'],
            'selected' => ['required', 'array', 'min:1', 'max:10'],
            'selected.*.question' => ['required', 'string', 'min:5'],
            'selected.*.A' => ['required', 'string'],
            'selected.*.B' => ['required', 'string'],
            'selected.*.C' => ['required', 'string'],
            'selected.*.D' => ['required', 'string'],
            'selected.*.answer' => ['required', 'in:A,B,C,D'],
        ]);

        $selected = $request->selected;

        $quiz = Quiz::create([
            'course_id' => $course->id,
            'created_by' => auth()->id(),
            'creator_role' => auth()->user()->role,
            'topic' => $request->topic,
            'total_questions' => count($selected),
            'title' => $request->topic, // optional if you have title column
        ]);

        foreach (array_values($selected) as $i => $q) {
            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => $q['question'],
                'option_a' => $q['A'],
                'option_b' => $q['B'],
                'option_c' => $q['C'],
                'option_d' => $q['D'],
                'correct_option' => $q['answer'],
                'sort_order' => $i + 1,
            ]);
        }

        return redirect()->back()->with('success', 'Quiz saved successfully!');
    }

    // ---------------- AUTH ----------------
    private function authorizeTrainerCourse($course)
    {
        if (auth()->user()->role === 'trainer') {
            abort_if(($course->trainer_id ?? null) != auth()->id(), 403);
        }
    }

    // ---------------- AI (Gemini reuse) ----------------
    private function generateMcqsWithAi(Course $course, string $topic, int $count): array
    {
        $prompt = $this->buildPrompt($course, $topic, $count);

        $resp = $this->callAi($prompt);

        if (!$resp['ok']) {
            // return empty + debug
            return [
                [],
                [
                    'http_ok' => false,
                    'status' => $resp['status'] ?? null,
                    'error' => $resp['error'] ?? 'Unknown',
                    'model' => $resp['model'] ?? null,
                    'picked_model' => $resp['picked_model'] ?? null,
                ]
            ];
        }

        $text = $resp['text'] ?? '';

        // extract JSON array robustly
        $jsonArray = null;
        if (preg_match('/\[[\s\S]*\]/', $text, $m)) {
            $jsonArray = $m[0];
        }

        if (!$jsonArray) {
            return [
                [],
                [
                    'http_ok' => true,
                    'status' => 200,
                    'error' => 'No JSON array found in model output',
                    'model' => $resp['model'] ?? null,
                    'raw_text_preview' => substr($text, 0, 1200),
                ]
            ];
        }

        $data = json_decode($jsonArray, true);
        if (!is_array($data)) {
            return [
                [],
                [
                    'http_ok' => true,
                    'status' => 200,
                    'error' => 'JSON decode failed: ' . json_last_error_msg(),
                    'model' => $resp['model'] ?? null,
                    'extracted_json_preview' => substr($jsonArray, 0, 1200),
                ]
            ];
        }

        return [
            $data,
            [
                'http_ok' => true,
                'status' => 200,
                'model' => $resp['model'] ?? null,
                'picked_model' => $resp['picked_model'] ?? null,
            ]
        ];
    }



    private function extractJsonArray(string $text): ?string
    {
        $start = strpos($text, '[');
        $end = strrpos($text, ']');
        if ($start === false || $end === false || $end <= $start)
            return null;

        return substr($text, $start, $end - $start + 1);
    }



    private function buildPrompt(Course $course, string $topic, int $count): string
    {
        $title = $course->title ?? 'Course';
        $desc = Str::limit(strip_tags($course->description ?? ''), 600);

        return <<<PROMPT
    Return ONLY a valid JSON array. No markdown, no explanation, no extra text.
    
    Generate exactly {$count} MCQs for:
    Course: {$title}
    Topic: {$topic}
    Course Description: {$desc}
    
    JSON schema (MUST follow exactly):
    [
      {
        "question": "string",
        "options": {"A":"string","B":"string","C":"string","D":"string"},
        "answer": "A"
      }
    ]
    
    Rules:
    - "answer" must be exactly one of: "A","B","C","D"
    - options must ALWAYS have A,B,C,D keys (not array)
    - Keep questions short and clear
    PROMPT;
    }


    private function callAi(string $prompt): array
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return ['ok' => false, 'text' => '', 'error' => 'GEMINI_API_KEY missing'];
        }

        // try env model first, then auto-pick
        $model = env('GEMINI_MODEL', 'gemini-pro');

        $first = $this->callGeminiGenerate($apiKey, $model, $prompt);

        // if model not found / not supported -> pick a working one and retry
        if (!$first['ok'] && $this->looksLikeModelError($first['error'] ?? '')) {
            $picked = $this->pickGenerateContentModel($apiKey);
            if ($picked) {
                $second = $this->callGeminiGenerate($apiKey, $picked, $prompt);
                $second['picked_model'] = $picked;
                return $second;
            }
        }

        return $first;
    }

    private function callGeminiGenerate(string $apiKey, string $model, string $prompt): array
    {
        // ✅ USE v1 (NOT v1beta)
        $url = "https://generativelanguage.googleapis.com/v1/models/{$model}:generateContent?key={$apiKey}";

        $payload = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        [
                            "text" => $prompt . "\n\nIMPORTANT: Output ONLY valid JSON array. No markdown. No extra text."
                        ]
                    ]
                ]
            ],
            // ✅ optional but helpful
            "generationConfig" => [
                "temperature" => 0.6,
                "maxOutputTokens" => 2048,
            ]
        ];

        $res = Http::timeout(40)->post($url, $payload);

        if (!$res->successful()) {
            $err = $res->json('error.message') ?? $res->body();

            Log::error('Gemini generateContent failed', [
                'status' => $res->status(),
                'model' => $model,
                'error' => $err,
                'body_preview' => substr($res->body(), 0, 1200),
            ]);

            return ['ok' => false, 'text' => '', 'error' => $err, 'status' => $res->status(), 'model' => $model];
        }

        $text = $res->json('candidates.0.content.parts.0.text') ?? '';

        Log::info('Gemini generateContent OK', [
            'model' => $model,
            'text_preview' => substr($text, 0, 800),
        ]);

        return ['ok' => true, 'text' => $text, 'error' => null, 'status' => 200, 'model' => $model];
    }

    private function pickGenerateContentModel(string $apiKey): ?string
    {
        // ✅ USE v1 (NOT v1beta)
        $listUrl = "https://generativelanguage.googleapis.com/v1/models?key={$apiKey}";
        $res = Http::timeout(20)->get($listUrl);

        if (!$res->successful()) {
            Log::error('Gemini ListModels failed', ['status' => $res->status(), 'body' => substr($res->body(), 0, 1200)]);
            return null;
        }

        $models = $res->json('models') ?? [];

        foreach ($models as $m) {
            $name = $m['name'] ?? null; // e.g. "models/gemini-1.5-flash"
            $methods = $m['supportedGenerationMethods'] ?? [];

            if (!$name)
                continue;

            if (in_array('generateContent', $methods, true)) {
                return str_replace('models/', '', $name);
            }
        }

        return null;
    }



    private function looksLikeModelError(string $msg): bool
    {
        $m = strtolower($msg);
        return str_contains($m, 'not found')
            || str_contains($m, 'not supported')
            || str_contains($m, 'call listmodels')
            || str_contains($m, 'models/');
    }
    public function show(Quiz $quiz)
    {
        // trainer restriction: only his created quizzes OR his course quizzes
        if (auth()->user()->role === 'trainer') {
            abort_if($quiz->created_by != auth()->id(), 403);
        }

        $quiz->load(['course', 'questions']);

        $viewPrefix = auth()->user()->role === 'trainer' ? 'trainer' : 'admin';
        return view($viewPrefix . '.quizzes.show', compact('quiz'));
    }

    public function destroy(Quiz $quiz)
{
    // trainer restriction (sirf apna quiz delete kar sake)
    if (auth()->user()->role === 'trainer') {
        abort_if($quiz->created_by != auth()->id(), 403);
    }

    // load course for extra safety (optional)
    $quiz->load('course');

    // ✅ delete questions first (agar FK cascade nahi hai)
    QuizQuestion::where('quiz_id', $quiz->id)->delete();

    // ✅ delete quiz
    $quiz->delete();

    $prefix = auth()->user()->role === 'trainer' ? 'trainer.' : 'admin.';
    return redirect()->route($prefix.'quizzes.index')->with('success', 'Quiz deleted successfully!');
}
}
