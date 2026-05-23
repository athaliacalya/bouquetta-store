<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Bouquet;
use App\Models\Flower;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Testimonials — kept as static content (no DB needed).
     */
    protected array $testimonials = [
        ['text' => "I ordered the Sakura Garden for my mom's birthday and she cried — in the best way possible. The personalized letter made it extra special.", 'author' => 'Ayu Rahmawati', 'city' => 'Jakarta',    'stars' => 5, 'bg' => '#FCE4EC'],
        ['text' => "The bouquet builder is so fun! I spent an hour mixing flowers and the result was absolutely stunning. Will definitely order again.", 'author' => 'Sari Kusuma',   'city' => 'Bandung',    'stars' => 5, 'bg' => '#E1F5FE'],
        ['text' => "What I love most is that these are illustrations, not photos. It feels so unique and artistic. My girlfriend loved it!", 'author' => 'Rizky Pratama',  'city' => 'Surabaya',   'stars' => 5, 'bg' => '#E8F5E9'],
        ['text' => "The personal letter feature is a game-changer. Written in that beautiful handwriting style on actual printed paper. So romantic.", 'author' => 'Dina Maharani',  'city' => 'Yogyakarta', 'stars' => 5, 'bg' => '#FFF3E0'],
        ['text' => "Ordered for my wedding and got compliments from every single guest. Bouquetta's quality and attention to detail is just unmatched.", 'author' => 'Priya Santoso',  'city' => 'Bali',       'stars' => 5, 'bg' => '#EDE7F6'],
        ['text' => "Fast delivery, beautiful packaging, and the flowers looked exactly like the preview. Five stars without hesitation!", 'author' => 'Maya Putri',     'city' => 'Semarang',   'stars' => 5, 'bg' => '#FAE8EC'],
    ];

    /**
     * Best seller bouquet definitions.
     */
    protected array $bestSellers = [
        ['name' => 'The Romance Set',   'flower_slugs' => ['rose','peony'],                    'price' => 195000, 'tag' => 'Best Seller', 'bg' => ['#FCE4EC','#F5EDDF'], 'meaning' => 'Love & Prosperity'],
        ['name' => 'Morning Bliss',     'flower_slugs' => ['daisy','daffodil','narcissus'],     'price' => 145000, 'tag' => 'New Arrival', 'bg' => ['#FFF9C4','#E8F5E9'], 'meaning' => 'Joy & New Beginnings'],
        ['name' => 'Violet Dreams',     'flower_slugs' => ['violet','morningglory','gladiolus'],'price' => 165000, 'tag' => null,          'bg' => ['#EDE7F6','#F5EDDF'], 'meaning' => 'Faithfulness & Strength'],
        ['name' => 'Sakura Garden',     'flower_slugs' => ['carnation','peony','rose'],         'price' => 225000, 'tag' => 'Limited',     'bg' => ['#FCE4EC','#FAD5DC'], 'meaning' => 'Deep Love & Admiration'],
        ['name' => 'Warm Embrace',      'flower_slugs' => ['marigold','carnation','daisy'],     'price' => 125000, 'tag' => null,          'bg' => ['#FFF3E0','#FFF9C4'], 'meaning' => 'Warmth & Purity'],
        ['name' => 'Water Garden',      'flower_slugs' => ['waterlily','narcissus','violet'],   'price' => 175000, 'tag' => 'Trending',    'bg' => ['#E1F5FE','#EDE7F6'], 'meaning' => 'Purity & Rebirth'],
    ];

    /**
     * Show the home page.
     */
    public function index(): \Illuminate\View\View
    {
        $flowers = Flower::active()->get();

        return view('home', [
            'flowers'      => $flowers,
            'testimonials' => $this->testimonials,
            'bestSellers'  => $this->bestSellers,
        ]);
    }

    /**
     * Handle newsletter subscription.
     */
    public function subscribe(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        Subscriber::firstOrCreate(
            ['email' => $request->email],
            ['is_active' => true]
        );

        return response()->json(['success' => true, 'message' => 'Subscribed successfully!']);
    }
}