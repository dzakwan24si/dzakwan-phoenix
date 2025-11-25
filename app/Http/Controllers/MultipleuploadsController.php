<?php

namespace App\Http\Controllers;

use App\Models\Multipleuploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MultipleuploadsController extends Controller
{
    // Fungsi untuk Menyimpan File
    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:doc,docx,pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'ref_table' => 'required',
            'ref_id' => 'required'
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // 1. Buat nama file unik
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // 2. Simpan ke folder 'public/uploads'
                $file->move(public_path('uploads'), $filename);

                // 3. Simpan ke Database
                Multipleuploads::create([
                    'filename' => $filename,
                    'ref_table' => $request->ref_table,
                    'ref_id' => $request->ref_id,
                ]);
            }
            return back()->with('success', 'File berhasil diupload!');
        }

        return back()->with('error', 'Gagal upload file.');
    }

    // Fungsi untuk Menghapus File
    public function destroy($id)
    {
        $fileData = Multipleuploads::findOrFail($id);
        
        // 1. Hapus file fisik di folder public/uploads
        $filePath = public_path('uploads/' . $fileData->filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // 2. Hapus data di database
        $fileData->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }
}