<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MiniAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(15);
        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::orderBy('name')->get();
        return view('admin.kategori.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $category = Category::create($data);

        MiniAudit::create([
            'user_id'=>auth()->id(),
            'action'=>'create_category',
            'meta'=>$category->id,
            'ip_address'=>$request->ip()
        ]);

        return redirect()->route('admin.kategori.index')->with('success','Kategori berhasil dibuat.');
    }

    public function edit(Category $kategori)
    {
        $parents = Category::where('id','!=',$kategori->id)->orderBy('name')->get();
        return view('admin.kategori.edit', compact('kategori','parents'));
    }

    public function update(Request $request, Category $kategori)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // mencegah circular parent
        if (!empty($data['parent_id'])) {
            $newParent = Category::find($data['parent_id']);
            if ($newParent && ($newParent->id == $kategori->id || $newParent->isDescendantOf($kategori))) {
                return back()->withErrors([
                    'parent_id' => 'Parent tidak valid (membuat siklus).'
                ]);
            }
        }

        $data['slug'] = Str::slug($data['name']);
        $kategori->update($data);

        MiniAudit::create([
            'user_id'=>auth()->id(),
            'action'=>'update_category',
            'meta'=>$kategori->id,
            'ip_address'=>$request->ip()
        ]);

        return redirect()->route('admin.kategori.index')->with('success','Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, Category $kategori)
    {
        $name = $kategori->name;
        $kategori->delete();

        MiniAudit::create([
            'user_id'=>auth()->id(),
            'action'=>'delete_category',
            'meta'=>$name,
            'ip_address'=>$request->ip()
        ]);

        return redirect()->route('admin.kategori.index')->with('success','Kategori berhasil dihapus.');
    }
}
