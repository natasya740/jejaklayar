<?php

namespace App\Http\Controllers;

// use App\Models\Gallery; // Uncomment jika sudah ada model Gallery

class HomeController extends Controller
{
    /**
     * Display home page dengan circular gallery
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data gallery items
        $galleryItems = $this->getGalleryItems();

        return view('home', compact('galleryItems'));
    }

    /**
     * Get gallery items untuk circular gallery
     *
     * @return array
     */
    private function getGalleryItems()
    {
        // ============================================
        // OPSI 1: Gunakan data dari database
        // ============================================
        // Uncomment code di bawah jika sudah ada table gallery di database

        /*
        return Gallery::select('image', 'title', 'description')
            ->where('is_active', true)
            ->where('type', 'hero') // atau filter lain sesuai kebutuhan
            ->orderBy('order', 'asc')
            ->limit(12) // Maksimal 12-15 items untuk performa optimal
            ->get()
            ->map(function($item) {
                return [
                    'image' => asset('storage/' . $item->image), // Sesuaikan path
                    'text' => $item->title
                ];
            })
            ->toArray();
        */

        // ============================================
        // OPSI 2: Data static/hardcoded (untuk testing)
        // ============================================
        return [
            [
                'image' => asset('images/circular-gallery/circular-gallery(1).png'),
                'text' => 'Tari Tradisional Melayu',
            ],
            [
                'image' => asset('images/circular-gallery/circular-gallery(2).png'),
                'text' => 'Pakaian Adat Bengkalis',
            ],
            [
                'image' => asset('images/circular-gallery/circular-gallery(3).png'),
                'text' => 'Istana Sultan Bengkalis',
            ],
            [
                'image' => asset('images/circular-gallery/circular-gallery(4).png'),
                'text' => 'Masjid Bersejarah',
            ],
            [
                'image' => asset('images/circular-gallery/circular-gallery(5).png'),
                'text' => 'Foto Lawas Bengkalis',
            ],
            [
                'image' => asset('images/circular-gallery/circular-gallery(6).png'),
                'text' => 'Pelabuhan Tempo Dulu',
            ],
            // Tambahkan lebih banyak items sesuai kebutuhan
        ];

        // ============================================
        // OPSI 3: Menggunakan Picsum Photos (untuk demo/testing)
        // ============================================
        // Uncomment code di bawah untuk menggunakan placeholder images

        /*
        $items = [];
        $titles = [
            'Tari Melayu', 'Pakaian Adat', 'Istana Sultan',
            'Masjid Bersejarah', 'Pelabuhan', 'Arsip Foto',
            'Upacara Adat', 'Musik Tradisional', 'Kerajinan Tangan',
            'Kuliner Khas', 'Festival Budaya', 'Pantai Bengkalis'
        ];

        foreach ($titles as $index => $title) {
            $items[] = [
                'image' => "https://picsum.photos/seed/" . ($index + 100) . "/800/600",
                'text' => $title
            ];
        }

        return $items;
        */

        // ============================================
        // OPSI 4: Return empty array (akan gunakan default images dari JS)
        // ============================================
        // return [];
    }

    /**
     * Alternative: API endpoint untuk AJAX loading gallery
     * Berguna jika ingin load gallery secara async
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGalleryData()
    {
        $items = $this->getGalleryItems();

        return response()->json([
            'success' => true,
            'data' => $items,
            'count' => count($items),
        ]);
    }
}
