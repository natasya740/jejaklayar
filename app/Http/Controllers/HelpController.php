<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Halaman FAQ / Pertanyaan
     */
    public function faq()
    {
        $faqs = [
            [
                'question' => 'Apa itu Jejak Layar?',
                'answer' => 'Jejak Layar adalah platform digital yang didedikasikan untuk melestarikan dan mempromosikan budaya Melayu Bengkalis. Kami menyediakan artikel, pustaka digital, dan berbagai konten tentang warisan budaya lokal.'
            ],
            [
                'question' => 'Bagaimana cara menjadi kontributor?',
                'answer' => 'Anda dapat mendaftar melalui halaman Register dan memilih role sebagai Kontributor. Setelah akun Anda disetujui, Anda dapat mulai mengirimkan artikel untuk direview oleh admin.'
            ],
            [
                'question' => 'Apakah saya bisa mengunduh konten dari Pustaka Digital?',
                'answer' => 'Ya, sebagian besar konten di Pustaka Digital dapat diunduh untuk keperluan edukasi dan penelitian. Namun, mohon cantumkan sumber jika Anda menggunakan konten kami.'
            ],
            [
                'question' => 'Berapa lama waktu review artikel?',
                'answer' => 'Proses review artikel biasanya memakan waktu 1-3 hari kerja. Admin akan mereview konten Anda dan memberikan feedback jika ada revisi yang diperlukan.'
            ],
            [
                'question' => 'Bagaimana cara menghubungi admin?',
                'answer' => 'Anda dapat menghubungi admin melalui email di admin@jejaklayar.com atau melalui WhatsApp yang tersedia di tombol bantuan floating di pojok kanan bawah.'
            ],
            [
                'question' => 'Apakah ada panduan penulisan artikel?',
                'answer' => 'Ya, kami menyediakan Panduan Kontributor yang lengkap. Anda dapat mengaksesnya melalui menu bantuan atau dashboard kontributor Anda.'
            ],
            [
                'question' => 'Bagaimana kebijakan hak cipta konten?',
                'answer' => 'Semua konten yang diunggah ke Jejak Layar tetap menjadi hak cipta penulis asli. Namun, dengan mengunggah, Anda memberikan izin kepada kami untuk mempublikasikan dan mendistribusikan konten tersebut di platform kami.'
            ],
            [
                'question' => 'Apakah saya bisa mengedit artikel yang sudah dipublikasi?',
                'answer' => 'Untuk kontributor, Anda dapat mengajukan permintaan edit kepada admin. Untuk admin, artikel dapat diedit langsung melalui dashboard admin.'
            ]
        ];

        return view('help.faq', compact('faqs'));
    }

    /**
     * Halaman Panduan Kontributor
     */
    public function panduan()
    {
        $guidelines = [
            [
                'title' => 'Persiapan Menulis',
                'icon' => 'fa-pencil-alt',
                'items' => [
                    'Pilih topik yang relevan dengan budaya Melayu Bengkalis',
                    'Lakukan riset mendalam tentang topik yang akan ditulis',
                    'Siapkan referensi dan sumber yang kredibel',
                    'Pastikan informasi yang Anda sampaikan akurat dan terverifikasi'
                ]
            ],
            [
                'title' => 'Format Penulisan',
                'icon' => 'fa-file-alt',
                'items' => [
                    'Gunakan Bahasa Indonesia yang baik dan benar',
                    'Judul artikel maksimal 100 karakter, jelas dan menarik',
                    'Paragraf pembuka harus engaging dan menjelaskan inti artikel',
                    'Gunakan subjudul untuk memecah konten yang panjang',
                    'Minimal 500 kata untuk artikel standar'
                ]
            ],
            [
                'title' => 'Penggunaan Media',
                'icon' => 'fa-images',
                'items' => [
                    'Sertakan minimal 1 gambar featured yang relevan',
                    'Ukuran gambar maksimal 2MB per file',
                    'Format yang didukung: JPG, PNG, WebP',
                    'Pastikan Anda memiliki hak untuk menggunakan gambar',
                    'Tambahkan caption atau keterangan untuk setiap gambar'
                ]
            ],
            [
                'title' => 'Kategori & Tag',
                'icon' => 'fa-tags',
                'items' => [
                    'Pilih kategori yang paling sesuai dengan artikel Anda',
                    'Gunakan sub-kategori untuk klasifikasi yang lebih spesifik',
                    'Tag membantu pembaca menemukan artikel terkait',
                    'Maksimal 5-7 tag per artikel'
                ]
            ],
            [
                'title' => 'Proses Review',
                'icon' => 'fa-check-circle',
                'items' => [
                    'Artikel yang dikirim akan direview oleh admin dalam 1-3 hari kerja',
                    'Admin dapat memberikan feedback untuk perbaikan',
                    'Pastikan untuk memeriksa notifikasi secara berkala',
                    'Jika ditolak, Anda dapat merevisi dan mengirim ulang',
                    'Artikel yang disetujui akan segera dipublikasikan'
                ]
            ],
            [
                'title' => 'Etika & Aturan',
                'icon' => 'fa-gavel',
                'items' => [
                    'Dilarang keras melakukan plagiarisme',
                    'Hindari konten yang mengandung SARA atau kebencian',
                    'Hormati privasi dan hak cipta orang lain',
                    'Jangan menyebarkan informasi yang belum terverifikasi',
                    'Artikel harus objektif dan tidak bersifat promosi komersial'
                ]
            ]
        ];

        $tips = [
            'Gunakan gaya bahasa yang mudah dipahami oleh berbagai kalangan',
            'Tambahkan contoh konkret atau studi kasus jika memungkinkan',
            'Sertakan referensi di akhir artikel untuk meningkatkan kredibilitas',
            'Review kembali artikel Anda sebelum submit',
            'Jangan ragu untuk bertanya kepada admin jika ada yang tidak jelas'
        ];

        return view('help.panduan', compact('guidelines', 'tips'));
    }
}