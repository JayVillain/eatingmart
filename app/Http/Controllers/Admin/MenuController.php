<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        return view('admin.menus');
    }
    
    public function list()
    {
        $menus = Menu::all();
        return response()->json($menus);
    }

    // METHOD SHOW YANG HILANG
    public function show(Menu $menu)
    {
        return response()->json($menu);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('menu_images', 'public');
        
        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => Storage::url($imagePath),
        ]);

        return response()->json($menu, 201);
    }

    // PERBAIKAN DI METHOD UPDATE
    public function update(Request $request, Menu $menu)
    {
        // Validasi
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Cek jika ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $menu->image_url));
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validatedData['image_url'] = Storage::url($imagePath);
        }
        
        // Perbarui data
        $menu->update($validatedData);
        
        return response()->json($menu);
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $menu->image_url));
        }
        $menu->delete();
        return response()->json(null, 204);
    }
}