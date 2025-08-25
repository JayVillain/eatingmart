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

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $imagePath = $menu->image_url;
        if ($request->hasFile('image')) {
            if ($menu->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $menu->image_url));
            }
            $imagePath = Storage::url($request->file('image')->store('menu_images', 'public'));
        }

        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $imagePath,
        ]);

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