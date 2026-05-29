<?php

namespace App\Http\Controllers;

use App\Models\Menu;

use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function index(Request $request)
{

    $search = $request->search;

    $category = $request->category;

    $menus = Menu::query()

        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                    $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'category',
                    'like',
                    "%{$search}%"
                );

            });

        })

        ->when(

            $category
            && $category !== 'all',

            function ($query) use ($category) {

                $query->where(
                    'category',
                    $category
                );

            }

        )

        ->latest()

        ->get();

    return response()->json($menus);

}
        public function uploadImage(Request $request)
        {

            $request->validate([

                'image' => 'required|image',

                'menu_id' => 'required'

            ]);

            $menu = Menu::findOrFail(
                $request->menu_id
            );

            $path = $request
                ->file('image')
                ->store('menus', 'public');

            $menu->image = $path;

            $menu->save();

            return response()->json([

                'message' => 'Upload berhasil',

                'image' => $path

            ]);

        }
        public function store(Request $request)
            {

                $validated = $request->validate([

                    'name' => 'required',

                    'category' => 'required',

                    'origin' => 'nullable',

                    'price' => 'required',

                    'description' => 'required',

                    'full_description' => 'required',

                    'temperature' => 'required'

                ]);

                $menu = Menu::create($validated);

                return response()->json([

                    'message' => 'Menu berhasil dibuat',

                    'menu' => $menu

                ]);

            }
            public function update(
                Request $request,
                $id
            )
            {

                $menu = Menu::findOrFail($id);

                $menu->update($request->all());

                return response()->json([

                    'message' => 'Menu berhasil diupdate',

                    'menu' => $menu

                ]);

            }
            public function destroy($id)
                {

                    $menu = Menu::findOrFail($id);

                    $menu->delete();

                    return response()->json([

                        'message' => 'Menu berhasil dihapus'

                    ]);

                }
}
