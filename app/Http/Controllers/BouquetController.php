<?php
// app/Http/Controllers/BouquetController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BouquetController extends Controller
{
    /**
     * Return all available flowers as JSON (for AJAX/SPA usage).
     */
    public function flowers(): JsonResponse
    {
        $flowers = [
            ['id' => 'carnation',    'name' => 'Carnation',     'meaning' => 'Love & admiration'],
            ['id' => 'violet',       'name' => 'Violet',        'meaning' => 'Faithfulness'],
            ['id' => 'daffodil',     'name' => 'Daffodil',      'meaning' => 'New beginnings'],
            ['id' => 'daisy',        'name' => 'Daisy',         'meaning' => 'Innocence & purity'],
            ['id' => 'rose',         'name' => 'Rose',          'meaning' => 'Deep love'],
            ['id' => 'waterlily',    'name' => 'Water Lily',    'meaning' => 'Purity of heart'],
            ['id' => 'gladiolus',    'name' => 'Gladiolus',     'meaning' => 'Strength & integrity'],
            ['id' => 'morningglory', 'name' => 'Morning Glory', 'meaning' => 'Affection'],
            ['id' => 'marigold',     'name' => 'Marigold',      'meaning' => 'Warmth & creativity'],
            ['id' => 'peony',        'name' => 'Peony',         'meaning' => 'Romance & prosperity'],
            ['id' => 'narcissus',    'name' => 'Narcissus',     'meaning' => 'Self-love & rebirth'],
        ];

        return response()->json(['flowers' => $flowers]);
    }

    /**
     * Store a new bouquet in the session.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'flowers'  => 'required|array|min:1|max:8',
            'flowers.*'=> 'string',
            'message'  => 'nullable|string|max:500',
        ]);

        $code = Str::random(8);

        // In production: save to DB (Bouquet model)
        // For demo: save in session
        session(["bouquet_{$code}" => [
            'flowers' => $validated['flowers'],
            'message' => $validated['message'] ?? '',
            'code'    => $code,
            'created_at' => now()->toIso8601String(),
        ]]);

        return response()->json([
            'success' => true,
            'code'    => $code,
            'share_url' => route('bouquet.view', $code),
        ]);
    }

    /**
     * Send a bouquet (generate shareable link).
     */
    public function send(Request $request): JsonResponse
    {
        return $this->store($request);
    }

    /**
     * Get a saved bouquet by code (API).
     */
    public function show(string $code): JsonResponse
    {
        $bouquet = session("bouquet_{$code}");

        if (!$bouquet) {
            return response()->json(['error' => 'Bouquet not found'], 404);
        }

        return response()->json($bouquet);
    }

    /**
     * View a shared bouquet page.
     */
    public function view(string $code): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        $bouquet = session("bouquet_{$code}");

        if (!$bouquet) {
            return redirect()->route('home')->with('error', 'This bouquet link has expired.');
        }

        return view('pages.shared-bouquet', compact('bouquet'));
    }
}
