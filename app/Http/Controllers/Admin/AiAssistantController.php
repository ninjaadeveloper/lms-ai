<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiAssistantController extends Controller
{
    public function index()
    {
        return view('admin.ai.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userMessage = trim($request->message);

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['reply' => 'Gemini API key missing (GEMINI_API_KEY).'], 500);
        }

        // ✅ Use env model (default: gemini-pro). If it fails, we auto-pick from ListModels.
        $model = env('GEMINI_MODEL', 'gemini-pro');

        $reply = $this->callGemini($apiKey, $model, $userMessage);

        // If model not found / not supported, auto-pick a working model
        if (isset($reply['error']) && $this->looksLikeModelError($reply['error'])) {
            $picked = $this->pickGenerateContentModel($apiKey);
            if ($picked) {
                $reply = $this->callGemini($apiKey, $picked, $userMessage);
            }
        }

        if (isset($reply['error'])) {
            return response()->json(['reply' => 'Gemini API error: ' . $reply['error']], 500);
        }

        // ✅ Force: English/Roman Urdu only (remove Urdu/Hindi/Arabic scripts if any slip in)
        $clean = $this->stripNonLatinScripts($reply['text'] ?? "Sorry, I couldn't generate a reply.");

        return response()->json(['reply' => $clean]);
    }

    private function callGemini(string $apiKey, string $model, string $userMessage): array
    {
        // Gemini generateContent endpoint (v1beta)
        // POST /v1beta/{model=models/*}:generateContent  (official) :contentReference[oaicite:1]{index=1}
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $systemRules = <<<TXT
You are a programming assistant.

RULES (must follow):
- Reply ONLY in English OR Roman Urdu.
- DO NOT use Hindi/Urdu/Arabic script characters.
- ONLY discuss coding, programming, software development, and tech careers.
- Do NOT promote admissions or courses.
- Keep it short and clear, use bullet points when possible.
TXT;

        $payload = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $systemRules . "\n\nUser Question:\n" . $userMessage]
                    ]
                ]
            ]
        ];

        $res = Http::timeout(20)->post($url, $payload);

        if (!$res->successful()) {
            return ['error' => ($res->json('error.message') ?? $res->body() ?? 'Unknown error')];
        }

        $text = $res->json('candidates.0.content.parts.0.text');

        return ['text' => $text ?: "Sorry, I couldn't generate a reply."];
    }

    private function looksLikeModelError(string $msg): bool
    {
        $m = strtolower($msg);
        return str_contains($m, 'not found')
            || str_contains($m, 'not supported')
            || str_contains($m, 'call listmodels')
            || str_contains($m, 'models/');
    }

    private function pickGenerateContentModel(string $apiKey): ?string
    {
        // GET /v1beta/models  (official) :contentReference[oaicite:2]{index=2}
        $listUrl = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";
        $res = Http::timeout(20)->get($listUrl);

        if (!$res->successful())
            return null;

        $models = $res->json('models') ?? [];
        foreach ($models as $m) {
            // Many responses include: name + supportedGenerationMethods (docs mention model metadata) :contentReference[oaicite:3]{index=3}
            $name = $m['name'] ?? null; // like "models/gemini-pro"
            $methods = $m['supportedGenerationMethods'] ?? [];

            if (!$name)
                continue;

            // we need generateContent support
            if (in_array('generateContent', $methods, true)) {
                // return short model id without "models/" prefix (because we build URL with models/{model})
                return str_replace('models/', '', $name);
            }
        }

        return null;
    }

    private function stripNonLatinScripts(string $text): string
    {
        // Remove Arabic/Urdu ranges + Devanagari (Hindi)
        // Keep Latin letters/numbers/punctuation.
        return preg_replace('/[\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}\x{0900}-\x{097F}]/u', '', $text) ?? $text;
    }
}
