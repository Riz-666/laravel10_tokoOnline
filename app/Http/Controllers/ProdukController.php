<?php

namespace App\Http\Controllers;
use App\Helpers\ImageHelper;
use App\Models\FotoProduk;
use App\Models\Kategori;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::orderBy('updated_at', 'desc')->get();
        return view('backend.v_produk.index', [
            'judul' => 'Data Produk',
            'index' => $produk,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'kategori' => $kategori,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nama_produk' => 'required|max:255|unique:produk',
                'detail' => 'required',
                'harga' => 'required',
                'berat' => 'required',
                'stok' => 'required',
                'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:2046',
            ],
            $messages = [
                'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
                'foto.max' => 'Ukuran file gambar Maksimal adalah 2048 KB.',
            ],
        );

        $validatedData['status'] = 0;
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk';
            // Simpan gambar asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $validatedData['foto'] = $fileName;
            // create thumbnail 1 (lg)
            $thumbnailLg = 'thumb_lg_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null);
            // create thumbnail 2 (md)
            $thumbnailMd = 'thumb_md_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519);
            // create thumbnail 3 (sm)
            $thumbnailSm = 'thumb_sm_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110);
            // Simpan nama file asli di database
            $validatedData['foto'] = $originalFileName;
        }

        $produk = new Produk();
        $produk->kategori_id = $request->kategori_id;
        $produk->user_id = Auth()->id();
        $produk->nama_produk = $request->nama_produk;
        $produk->detail = $request->detail;
        $produk->harga = $request->harga;
        $produk->berat = $request->berat;
        $produk->stok = $request->stok;
        $produk->foto = $validatedData['foto'];
        $produk->status = $validatedData['status'];

        $produk->save();

        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::with(['fotoProduk'])->findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.show', [
            'judul' => 'Detail Produk',
            'show' => $produk,
            'kategori' => $kategori,
        ]);
    }
    public function storeFoto(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'foto_produk.*' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ]);
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                // Buat nama file yang unik
                $extension = $file->getClientOriginalExtension();
                $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;
                $directory = 'storage/img-produk/';
                // Simpan dan resize gambar menggunakan ImageHelper
                ImageHelper::uploadAndResize($file, $directory, $filename, 800, null);
                // Simpan data ke database
                $fotoProduk = new fotoProduk();
                $fotoProduk->produk_id = $request->produk_id;
                $fotoProduk->foto = $filename;
                $fotoProduk->save();
            }
        }
        return redirect()
            ->route('backend.produk.show', $request->produk_id)
            ->with('success', 'Foto berhasil ditambahkan.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::with(['fotoProduk'])->findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.edit', [
            'judul' => 'Edit Produk',
            'show' => $produk,
            'kategori' => $kategori,
            'edit' => $produk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);
        $rules = [
            'nama_produk' => 'required|max:255|unique:produk,nama_produk,' . $id,
            'kategori_id' => 'required',
            'status' => 'required',
            'detail' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'stok' => 'required',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];
        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png,atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.',
        ];
        $validatedData['user_id'] = auth()->id();
        $validatedData = $request->validate($rules, $messages);
        if ($request->file('foto')) {
            //hapus gambar lama
            if ($produk->foto) {
                $oldImagePath = public_path('storage/img-produk/') . $produk->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $oldThumbnailLg = public_path('storage/img-produk/') . 'thumb_lg_' . $produk->foto;
                if (file_exists($oldThumbnailLg)) {
                    unlink($oldThumbnailLg);
                }
                $oldThumbnailMd = public_path('storage/img-produk/') . 'thumb_md_' . $produk->foto;
                if (file_exists($oldThumbnailMd)) {
                    unlink($oldThumbnailMd);
                }
                $oldThumbnailSm = public_path('storage/img-produk/') . 'thumb_sm_' . $produk->foto;
                if (file_exists($oldThumbnailSm)) {
                    unlink($oldThumbnailSm);
                }
            }
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk/';
            // Simpan gambar asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $validatedData['foto'] = $fileName;
            // create thumbnail 1 (lg)
            $thumbnailLg = 'thumb_lg_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null);
            // create thumbnail 2 (md)
            $thumbnailMd = 'thumb_md_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519);
            // create thumbnail 3 (sm)
            $thumbnailSm = 'thumb_sm_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110);
            // Simpan nama file asli di database
            $validatedData['foto'] = $originalFileName;
        }
        $produk->update($validatedData);
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $directory = public_path('storage/img-produk/');
        if ($produk->foto) {
            // Hapus gambar asli
            $oldImagePath = $directory . $produk->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            // Hapus thumbnail lg
            $thumbnailLg = $directory . 'thumb_lg_' . $produk->foto;
            if (file_exists($thumbnailLg)) {
                unlink($thumbnailLg);
            }
            // Hapus thumbnail md
            $thumbnailMd = $directory . 'thumb_md_' . $produk->foto;
            if (file_exists($thumbnailMd)) {
                unlink($thumbnailMd);
            }
            // Hapus thumbnail sm
            $thumbnailSm = $directory . 'thumb_sm_' . $produk->foto;
            if (file_exists($thumbnailSm)) {
                unlink($thumbnailSm);
            }
        }
        $produk->delete();
        return redirect()->route('backend.produk.index')->with('success', 'Berhasil Di Hapus');
    }
    public function destroy_foto_produk(string $id)
    {
        $produk = FotoProduk::findOrFail($id);
        if ($produk->foto) {
            $oldImagePath = public_path('storage/img-produk/') . $produk->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $produk->delete();

        return redirect()->route('backend.produk.show', $id)->with('success', 'Berhasil Di Hapus');
    }
    public function formProduk()
    {
        return view('backend.v_produk.form', [
            'judul' => 'Laporan Data Produk',
        ]);
    }
    // Method untuk Cetak Laporan Produk
    public function cetakProduk(Request $request)
    {
        // Menambahkan aturan validasi
        $request->validate(
            [
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            ],
            [
                'tanggal_awal.required' => 'Tanggal Awal harus diisi.',
                'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.',
                'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama dengan Tanggal Awal.',
            ],
        );
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $query = Produk::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])->orderBy('id', 'desc');
        $produk = $query->get();
        return view('backend.v_produk.cetak', [
            'judul' => 'Laporan Produk',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $produk,
        ]);
    }
}