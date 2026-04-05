<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GeminiOCRService
{
    public static function extractText($filePath)
    {
        try {
            $apiKey = config('services.gemini.key');

            $fullPath = Storage::disk('local')->path($filePath);

            if (!file_exists($fullPath)) {
                return null;
            }

            $mimeType = mime_content_type($fullPath);
            $imageData = base64_encode(file_get_contents($fullPath));

            $payload = [
                "contents" => [
                    [
                        "parts" => [
                            [
                                "text" => "Extract structured data from this student enrollment slip.

IMPORTANT:
- Extract EXACT values from the image
- DO NOT guess missing fields
- If not found, return null
- Combine multi-line values if needed

FIELDS TO EXTRACT:
- student_number
- first_name
- last_name
- date
- semester
- academic_year
- college
- course
- year
- section
- officially_enrolled (true if stamp/text like 'OFFICIALLY ENROLLED' is present, otherwise false)

RETURN ONLY VALID JSON:

{
  \"student_number\": \"\",
  \"first_name\": \"\",
  \"last_name\": \"\",
  \"date\": \"\",
  \"semester\": \"\",
  \"academic_year\": \"\",
  \"college\": \"\",
  \"course\": \"\",
  \"year\": \"\",
  \"section\": \"\",
  \"officially_enrolled\": true
}"
                            ],
                            [
                                "inline_data" => [
                                    "mime_type" => $mimeType,
                                    "data" => $imageData
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->post(
                    "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                    $payload
                );

            if (!$response->successful()) {
                return null;
            }

            $json = $response->json();

            $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$text) {
                return null;
            }

            // Extract JSON
            preg_match('/\{.*\}/s', $text, $matches);

            if (!isset($matches[0])) {
                return null;
            }

            $data = json_decode($matches[0], true);

            if (!is_array($data)) {
                return null;
            }

            return [
                'student_number' => $data['student_number'] ?? null,
                'first_name' => $data['first_name'] ?? null,
                'last_name' => $data['last_name'] ?? null,
                'enrollment_date' => $data['date'] ?? null,
                'semester' => $data['semester'] ?? null,
                'academic_year' => $data['academic_year'] ?? null,
                'college' => $data['college'] ?? null,
                'course' => $data['course'] ?? null,
                'year' => $data['year'] ?? null,
                'section' => $data['section'] ?? null,
                'officially_enrolled' => $data['officially_enrolled'] ?? false,
            ];

        } catch (\Exception $e) {
            return null;
        }
    }
}