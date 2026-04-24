@php($pageTitle = 'Tambah Buku')
@php($activePage = 'buku')
@extends('layouts.app')

@section('content')
    <div class="content-panel mx-auto max-w-2xl rounded-2xl p-6">
        <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Tambah Buku</h1>
                <p class="mt-1 text-sm text-slate-500">Isi data buku baru lalu simpan.</p>
            </div>
            <a href="{{ route('buku.index') }}" class="rounded-md button-secondary px-4 py-2 text-sm font-medium">Kembali</a>
        </div>

        @if (session('success'))
            <div class="mt-5 rounded-md bg-emerald-100 p-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="mt-5 rounded-md bg-red-100 p-3 text-sm text-red-800">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('buku.store') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-md border border-slate-300 px-3 py-2" required>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang') }}" class="w-full rounded-md border border-slate-300 px-3 py-2" required>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit') }}" class="w-full rounded-md border border-slate-300 px-3 py-2" required>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Tahun</label>
                <input type="number" name="tahun" min="1900" max="{{ date('Y') }}" value="{{ old('tahun') }}" class="w-full rounded-md border border-slate-300 px-3 py-2" required>
            </div>
            <button type="submit" class="w-full rounded-md button-primary px-4 py-2 font-medium">Simpan Buku</button>
        </form>
    </div>
@endsection
