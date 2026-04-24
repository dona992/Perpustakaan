<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('peminjaman.index', [
            'peminjaman' => Peminjaman::with(['anggota', 'buku'])->latest()->get(),
            'anggota' => Anggota::orderBy('nama')->get(),
            'buku' => Buku::orderBy('judul')->get(),
        ]);
    }

    public function create()
    {
        return view('peminjaman.create', [
            'anggota' => Anggota::orderBy('nama')->get(),
            'buku' => Buku::orderBy('judul')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'exists:anggota,id'],
            'buku_id' => ['required', 'exists:buku,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_kembali' => ['nullable', 'date', 'after_or_equal:tanggal_pinjam'],
            'status' => ['required', 'in:dipinjam,dikembalikan,terlambat'],
        ]);

        Peminjaman::create($validated);

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil disimpan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        return view('peminjaman.edit', [
            'peminjaman' => $peminjaman,
            'anggota' => Anggota::orderBy('nama')->get(),
            'buku' => Buku::orderBy('judul')->get(),
        ]);
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'exists:anggota,id'],
            'buku_id' => ['required', 'exists:buku,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_kembali' => ['nullable', 'date', 'after_or_equal:tanggal_pinjam'],
            'status' => ['required', 'in:dipinjam,dikembalikan,terlambat'],
        ]);

        $peminjaman->update($validated);

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        try {
            $peminjaman->delete();
        } catch (QueryException $exception) {
            return redirect()->route('peminjaman.index')->with('error', 'Data peminjaman tidak bisa dihapus karena terjadi kesalahan pada database.');
        }

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
