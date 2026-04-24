<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        return view('buku.index', [
            'buku' => Buku::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'pengarang' => ['required', 'string', 'max:100'],
            'penerbit' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'integer', 'digits:4', 'min:1900', 'max:' . date('Y')],
        ]);

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil disimpan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', [
            'buku' => $buku,
        ]);
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'pengarang' => ['required', 'string', 'max:100'],
            'penerbit' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'integer', 'digits:4', 'min:1900', 'max:' . date('Y')],
        ]);

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $masihDipakai = Peminjaman::where('buku_id', $buku->id)->exists();

        if ($masihDipakai) {
            return redirect()->route('buku.index')->with('error', 'Data buku tidak bisa dihapus karena masih dipakai pada data peminjaman.');
        }

        try {
            $buku->delete();
        } catch (QueryException $exception) {
            return redirect()->route('buku.index')->with('error', 'Data buku tidak bisa dihapus karena masih dipakai pada data peminjaman.');
        }

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus.');
    }
}
