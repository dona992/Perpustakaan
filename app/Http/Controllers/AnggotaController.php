<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        return view('anggota.index', [
            'anggota' => Anggota::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_induk' => ['required', 'string', 'max:30', 'unique:anggota,nomor_induk'],
            'nama' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        Anggota::create($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil disimpan.');
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', [
            'anggota' => $anggota,
        ]);
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nomor_induk' => ['required', 'string', 'max:30', 'unique:anggota,nomor_induk,' . $anggota->id],
            'nama' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        $anggota->update($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        $masihDipakai = Peminjaman::where('anggota_id', $anggota->id)->exists();

        if ($masihDipakai) {
            return redirect()->route('anggota.index')->with('error', 'Data anggota tidak bisa dihapus karena masih dipakai pada data peminjaman.');
        }

        try {
            $anggota->delete();
        } catch (QueryException $exception) {
            return redirect()->route('anggota.index')->with('error', 'Data anggota tidak bisa dihapus karena masih dipakai pada data peminjaman.');
        }

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}
