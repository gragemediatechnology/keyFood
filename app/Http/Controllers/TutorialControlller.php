<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class tutorialController extends Controller
{
    public function index()
    {
        // Path ke folder 'public/vidio'
        $videoDirectory = public_path('vidio');

        // Ambil semua file video dari folder
        $videos = File::files($videoDirectory);

        // Kirim data ke view blade
        return view('videos.index', compact('videos'));
    }
}
