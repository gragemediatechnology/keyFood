<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
class TutorialController extends Controller
{
    public function index()
    {
        // Path ke folder 'public/vidio'
        $videoDirectory = public_path('vidio');

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
