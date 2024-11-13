<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TutorialController extends Controller
{
    // public function index()
    // { 
    //     // Path ke folder 'public/vidio 123'
    //     $videoDirectory = public_path('vidio');

    //     // Ambil semua file video dari folder
    //     $videos = File::files($videoDirectory);
    //     dd($videoDirectory);


    //     // Ubah menjadi Collection agar bisa menggunakan fungsi seperti map
    //     $videos = collect($videos)->map(function ($file) {
    //         return [
    //             'filename' => $file->getFilename(),
    //             'path' => asset('vidio/' . $file->getFilename())
    //         ];
    //     });


    //     return view('tutorial', compact('videos'));
    // }

    public function index()
    {
        // Path ke folder 'storage/app/public/vidio'
        // $videoDirectory = storage_path('app/public/vidio');
        // $videoDirectory = base_path('vidio/tutorial_mengajukan_permintaan_sebagai_penjual.mp4');
        $videoDirectory = app_path('vidio/tutorial_mengajukan_permintaan_sebagai_penjual.mp4');

        // Cek apakah folder ada
        // if (!File::exists($videoDirectory)) {
        //     abort(404, "Folder vidio tidak ditemukan.");
        // }

        // Ambil semua file video dari folder
        $videos = File::files($videoDirectory);

        // Ubah menjadi Collection agar bisa menggunakan fungsi seperti map
        $videos = collect($videos)->map(function ($file) {
            return [
                'filename' => $file->getFilename(),
                'path' => asset('vidio/' . $file->getFilename())
            ];
        });

        return view('tutorial', compact('videos'));
    }
}
