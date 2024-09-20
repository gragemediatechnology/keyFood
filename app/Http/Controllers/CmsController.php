<?php

namespace App\Http\Controllers;

use App\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CmsController extends Controller
{
    public function index()
    {
        $companys = Cms::all();
        return view("admin.cms.index", compact("companys"));
    }

    public function edit($id)
    {
        $data = Cms::find($id);
        return view("admin.cms.edit", compact("data"));
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'lokasi' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_home_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_home_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_home_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Mengambil data perusahaan berdasarkan ID
        $company = Cms::findOrFail($id);

        // Mengupdate data perusahaan (input non-file)
        $company->company_name = $request->input('company_name');
        $company->phone = $request->input('phone');
        $company->email = $request->input('email');
        $company->lokasi = $request->input('lokasi');

        // Mengupdate gambar jika ada file yang diupload
        foreach (['logo', 'gambar_home_1', 'gambar_home_2', 'gambar_home_3'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $file = $request->file($imageField);
                $filename = time() . '_' . $file->getClientOriginalName();

                // Tentukan direktori penyimpanan di folder public
                $directory = $imageField === 'logo' ? 'img' : 'cms';
                $publicPath = public_path($directory);

                // Pastikan direktori tujuan sudah ada, jika belum buat folder
                if (!File::exists($publicPath)) {
                    File::makeDirectory($publicPath, 0755, true);
                }

                // Hapus gambar lama jika ada
                if ($company->$imageField && File::exists(public_path($company->$imageField))) {
                    File::delete(public_path($company->$imageField));
                    Log::info("Old $imageField deleted: " . $company->$imageField);
                }

                // Pindahkan file baru ke direktori public
                $file->move($publicPath, $filename);
                $company->$imageField = $directory . '/' . $filename;

                Log::info(ucfirst(str_replace('_', ' ', $imageField)) . " uploaded: " . $company->$imageField);
            }
        }

        // Menyimpan perubahan
        $company->save();
        Log::info('Company updated: ' . $company->id);

        // Redirect ke halaman yang diinginkan dengan pesan sukses
        return redirect()->route('admin.company.index')->with('success', 'Data perusahaan berhasil diperbarui.');

    }



}
