@php($pageTitle = 'Data Peminjaman')
@php($activePage = 'peminjaman')
@extends('layouts.app')

@section('content')
    <div class="content-panel rounded-2xl p-6">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Data Peminjaman</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola data peminjaman dari halaman ini.</p>
            </div>
            <button type="button" id="openPeminjamanModal" class="inline-flex items-center justify-center rounded-md button-primary px-4 py-2 text-sm font-semibold">
                + Tambah Peminjaman
            </button>
        </div>

        @if (session('success'))
            <div class="mt-5 rounded-md bg-emerald-100 p-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full table-frame border text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">No</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Anggota</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Buku</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Tanggal Pinjam</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Tanggal Kembali</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Status</th>
                        <th class="border border-slate-200 px-3 py-2 text-left text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $item)
                        <tr>
                            <td class="border border-slate-200 px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="border border-slate-200 px-3 py-2">{{ $item->anggota?->nama }}</td>
                            <td class="border border-slate-200 px-3 py-2">{{ $item->buku?->judul }}</td>
                            <td class="border border-slate-200 px-3 py-2">{{ $item->tanggal_pinjam }}</td>
                            <td class="border border-slate-200 px-3 py-2">{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td class="border border-slate-200 px-3 py-2">{{ ucfirst($item->status) }}</td>
                            <td class="border border-slate-200 px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('peminjaman.edit', $item) }}" class="rounded px-3 py-1 button-secondary">Edit</a>
                                    <form method="POST" action="{{ route('peminjaman.destroy', $item) }}" class="js-delete-form" data-confirm-message="Yakin hapus data peminjaman ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded px-3 py-1 button-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border border-slate-200 px-3 py-4 text-center text-slate-500">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="peminjamanModal" data-open-error="{{ ($errors->has('anggota_id') || $errors->has('buku_id') || $errors->has('tanggal_pinjam') || $errors->has('tanggal_kembali') || $errors->has('status')) ? '1' : '0' }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4">
        <div class="w-full max-w-xl rounded-2xl bg-white p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <h2 class="text-xl font-semibold text-slate-900">Tambah Peminjaman</h2>
                <button type="button" id="closePeminjamanModal" class="rounded-md bg-slate-100 px-3 py-1 text-sm text-slate-700 hover:bg-slate-200">Tutup</button>
            </div>

            <form method="POST" action="{{ route('peminjaman.store') }}" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Anggota</label>
                    <select name="anggota_id" class="w-full rounded-md border px-3 py-2 @error('anggota_id') border-red-400 @else border-slate-300 @enderror" required>
                        <option value="">Pilih anggota</option>
                        @foreach ($anggota as $item)
                            <option value="{{ $item->id }}" @selected(old('anggota_id') == $item->id)>{{ $item->nomor_induk }} - {{ $item->nama }}</option>
                        @endforeach
                    </select>
                    @error('anggota_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Buku</label>
                    <select name="buku_id" class="w-full rounded-md border px-3 py-2 @error('buku_id') border-red-400 @else border-slate-300 @enderror" required>
                        <option value="">Pilih buku</option>
                        @foreach ($buku as $item)
                            <option value="{{ $item->id }}" @selected(old('buku_id') == $item->id)>{{ $item->judul }} - {{ $item->pengarang }}</option>
                        @endforeach
                    </select>
                    @error('buku_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="w-full rounded-md border px-3 py-2 @error('tanggal_pinjam') border-red-400 @else border-slate-300 @enderror" required>
                    @error('tanggal_pinjam')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal Kembali (opsional)</label>
                    <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" class="w-full rounded-md border px-3 py-2 @error('tanggal_kembali') border-red-400 @else border-slate-300 @enderror">
                    @error('tanggal_kembali')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" class="w-full rounded-md border px-3 py-2 @error('status') border-red-400 @else border-slate-300 @enderror" required>
                        @foreach (['dipinjam', 'dikembalikan', 'terlambat'] as $status)
                            <option value="{{ $status }}" @selected(old('status', 'dipinjam') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full rounded-md button-primary px-4 py-2 font-medium">Simpan Peminjaman</button>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('peminjamanModal');
            const openBtn = document.getElementById('openPeminjamanModal');
            const closeBtn = document.getElementById('closePeminjamanModal');

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
