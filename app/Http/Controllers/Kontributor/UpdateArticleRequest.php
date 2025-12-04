<?php
// app/Http/Requests/Kontributor/UpdateArticleRequest.php

namespace App\Http\Requests\Kontributor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize()
    {
        // Pastikan artikel milik user yang login
        return $this->route('article')->user_id === auth()->id();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,pending',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul artikel maksimal 255 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'sub_category_id.required' => 'Sub kategori wajib dipilih.',
            'sub_category_id.exists' => 'Sub kategori yang dipilih tidak valid.',
            'excerpt.max' => 'Ringkasan maksimal 500 karakter.',
            'content.required' => 'Konten artikel wajib diisi.',
            'content.min' => 'Konten artikel minimal 100 karakter.',
            'featured_image.image' => 'File harus berupa gambar.',
            'featured_image.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, webp.',
            'featured_image.max' => 'Ukuran gambar maksimal 2MB.',
            'status.required' => 'Status artikel wajib dipilih.',
            'status.in' => 'Status artikel tidak valid.',
        ];
    }
}