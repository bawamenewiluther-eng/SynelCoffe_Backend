<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserPdf;

class UserController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:10240'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User tidak login'], 401);
        }

        // hapus foto lama
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // simpan foto baru
        $path = $request->file('photo')->store('photos', 'public');

        // update DB
        $user->photo = $path;
        $user->save();

        return response()->json([
            'photo' => $path
        ]);
    }
  public function uploadPdf(Request $request)
{
    try {

        // 🔥 Validasi
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240',
        ]);

        // 🔥 Pastikan user login
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User tidak login'
            ], 401);
        }

        // 🔥 Ambil file
        $file = $request->file('pdf');

        // 🔥 Simpan file
        $path = $file->store('pdfs', 'public');

        // 🔥 Simpan ke database
        UserPdf::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'title' => $file->getClientOriginalName(),
        ]);

        return response()->json([
            'message' => 'Upload berhasil'
        ]);

    } catch (\Exception $e) {

        // 🔥 Debug error jelas
        return response()->json([
            'message' => 'Error upload',
            'error' => $e->getMessage()
        ], 500);
    }
}
}