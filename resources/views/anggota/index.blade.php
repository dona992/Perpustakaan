@php($pageTitle = 'Data Anggota')
@php($activePage = 'anggota')
@extends('layouts.app')

@section('content')
    <div class="content-panel rounded-2xl p-6">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Data Anggota</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola data anggota dari halaman ini.</p>
            </div>
            <button type="button" id="openAnggotaModal" class="inline-flex items-center justify-center rounded-md button-primary px-4 py-2 text-sm font-semibold">
                + Tambah Anggota
            </button>
        </div>

        @if (session('success'))
            <div class="mt-5 rounded-md bg-emerald-100 p-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="mt-5 rounded-md bg-red-100 p-3 text-sm text-red-800">{{ session('error') }}</div>
        @endif

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full table-frame border text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">No</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Nomor Induk</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Nama</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Alamat</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anggota as $item)
                        <tr>
                            <td class="border border-slate-200 px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="border border-slate-200 px-3 py-2">{{ $item->nomor_induk }}</td>
                            <td class="border border-slate-200 px-3 py-2">{{ $item->nama }}</td>
                            <td class="border border-slate-200 px-3 py-2">{{ $item->alamat }}</td>
                            <td class="border border-slate-200 px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('anggota.edit', $item) }}" class="rounded px-3 py-1 button-secondary">Edit</a>
                                    <form method="POST" action="{{ route('anggota.destroy', $item) }}" class="js-delete-form" data-confirm-message="Yakin hapus data anggota ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded px-3 py-1 button-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-slate-200 px-3 py-4 text-center text-slate-500">Belum ada data anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="anggotaModal" data-open-error="{{ ($errors->has('nomor_induk') || $errors->has('nama') || $errors->has('alamat')) ? '1' : '0' }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4">
        <div class="w-full max-w-xl rounded-2xl bg-white p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <h2 class="text-xl font-semibold text-slate-900">Tambah Anggota</h2>
                <button type="button" id="closeAnggotaModal" class="rounded-md bg-slate-100 px-3 py-1 text-sm text-slate-700 hover:bg-slate-200">Tutup</button>
            </div>

            <form method="POST" action="{{ route('anggota.store') }}" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nomor Induk</label>
                    <input type="text" name="nomor_induk" value="{{ old('nomor_induk') }}" class="w-full rounded-md border px-3 py-2 @error('nomor_induk') border-red-400 @else border-slate-300 @enderror" required>
                    @error('nomor_induk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-md border px-3 py-2 @error('nama') border-red-400 @else border-slate-300 @enderror" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat') }}" class="w-full rounded-md border px-3 py-2 @error('alamat') border-red-400 @else border-slate-300 @enderror" required>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full rounded-md button-primary px-4 py-2 font-medium">Simpan Anggota</button>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('anggotaModal');
            const openBtn = document.getElementById('openAnggotaModal');
            const closeBtn = document.getElementById('closeAnggotaModal');

            const openModal = () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            const shouldOpenFromError = modal.dataset.openError === '1';
            if (shouldOpenFromError) {
                openModal();
            }
        })();
    </script>
@endsection
