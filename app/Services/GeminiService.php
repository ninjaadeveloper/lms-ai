<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function generateMcqs(string $topic, int $count = 10, ?string $courseTitle = null): array
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        $systemPrompt = "You are an expert quiz generator. Return STRICT JSON only.";
        $userPrompt = "Generate {$count} MCQs on topic: {$topic}."
            . ($courseTitle ? " Course: {$courseTitle}." : "")
            . " JSON format:
{
  \"questions\": [
    {
      \"question\": \"...\",
      \"options\": [\"A\",\"B\",\"C\",\"D\"],
      \"correct_index\": 0
    }
  ]
}
Rules: 4 options only, correct_index 0-3, no markdown, no extra text.";

        // NOTE: aapka chatbot jis endpoint/style se call karta hai,
        // wahi same yahan use karlo. Neeche generic example:
        $res = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                    "contents" => [
                        ["role" => "user", "parts" => [["text" => $systemPrompt . "\n" . $userPrompt]]]
                    ]
                ]);

        $text = data_get($res->json(), 'candidates.0.content.parts.0.text', '');
        $json = json_decode($text, true);

        return is_array($json) ? $json : ['questions' => []];
    }
}
