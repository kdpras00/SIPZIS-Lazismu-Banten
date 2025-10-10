<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json(['error' => 'Pesan tidak boleh kosong'], 400);
        }

        try {
            // Prompt sistem agar chatbot hanya fokus pada ZIS
            $context = "Kamu adalah asisten digital ahli dalam sistem pengelolaan zakat, infak, dan sedekah (SIPZIS). 
            Jawablah pertanyaan pengguna hanya seputar zakat, infak, sedekah, lembaga amil, mustahik, muzakki, sistem informasi zakat, pembayaran digital zakat, dan hal yang relevan.
            Jika pertanyaan di luar konteks, tolong jawab dengan sopan bahwa kamu hanya bisa membantu seputar pengelolaan zakat, infak, dan sedekah.";

            // API PUTER (Claude Sonnet)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer free',
            ])->post('https://api.puter.com/v1/chat/completions', [
                'model' => 'claude-sonnet-4',
                'messages' => [
                    ['role' => 'system', 'content' => $context],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
