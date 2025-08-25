<?php
namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class MenuController extends Controller
{
    public function index()
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
        }
        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $imagePath ? Storage::url($imagePath) : null,
        ]);
        return response()->json($menu, 201);
    }
    public function show(Menu $menu)
    {
        return response()->json($menu);
    }
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($menu->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $menu->image_url));
            }
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $menu->image_url = Storage::url($imagePath);
        }
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->save();
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