@php($pageTitle = 'Edit Peminjaman')
@php($activePage = 'peminjaman')
@extends('layouts.app')

@section('content')
    <div class="content-panel mx-auto max-w-2xl rounded-2xl p-6">
        <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Edit Peminjaman</h1>
                <p class="mt-1 text-sm text-slate-500">Perbarui data peminjaman yang sudah tersimpan.</p>
            </div>
            <a href="{{ route('peminjaman.index') }}" class="rounded-md button-secondary px-4 py-2 text-sm font-medium">Kembali</a>
        </div>

        @if ($errors->any())
            <div class="mt-5 rounded-md bg-red-100 p-3 text-sm text-red-800">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peminjaman.update', $peminjaman) }}" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="anggota_id" class="mb-1 block text-sm font-medium text-slate-700">Anggota</label>
                <select id="anggota_id" name="anggota_id" class="w-full rounded-md border border-slate-300 px-3 py-2" required>
                    <option value="">Pilih anggota</option>
                    @foreach ($anggota as $item)
                        <option value="{{ $item->id }}" @selected(old('anggota_id', $peminjaman->anggota_id) == $item->id)>
                            {{ $item->nomor_induk }} - {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="buku_id" class="mb-1 block text-sm font-medium text-slate-700">Buku</label>
                <select id="buku_id" name="buku_id" class="w-full rounded-md border border-slate-300 px-3 py-2" required>
                    <option value="">Pilih buku</option>
                    @foreach ($buku as $item)
                        <option value="{{ $item->id }}" @selected(old('buku_id', $peminjaman->buku_id) == $item->id)>
                            {{ $item->judul }} - {{ $item->pengarang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tanggal_pinjam" class="mb-1 block text-sm font-medium text-slate-700">Tanggal Pinjam</label>
                <input id="tanggal_pinjam" type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" class="w-full rounded-md border border-slate-300 px-3 py-2" required>
            </div>

            <div>
                <label for="tanggal_kembali" class="mb-1 block text-sm font-medium text-slate-700">Tanggal Kembali (opsional)</label>
                <input id="tanggal_kembali" type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" class="w-full rounded-md border border-slate-300 px-3 py-2">
            </div>

            <div>
                <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                <select id="status" name="status" class="w-full rounded-md border border-slate-300 px-3 py-2" required>
                    @foreach (['dipinjam', 'dikembalikan', 'terlambat'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $peminjaman->status) === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-md button-primary px-4 py-2 font-medium">Update</button>
                <a href="{{ route('peminjaman.index') }}" class="rounded-md button-secondary px-4 py-2 font-medium">Kembali</a>
            </div>
        </form>
    </div>
@endsection
