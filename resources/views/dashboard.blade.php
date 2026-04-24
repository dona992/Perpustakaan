@php($pageTitle = 'Dashboard')
@php($activePage = 'dashboard')
@extends('layouts.app')

@section('content')
    <div class="content-panel rounded-3xl p-7 lg:p-8">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">Dashboard Utama</p>
                <h1 class="mt-2 text-3xl font-extrabold text-slate-900">Selamat datang di Kelola Perpustakaan</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Ringkasan singkat data perpustakaan ditampilkan di sini agar Anda bisa melihat kondisi sistem dengan cepat.</p>
            </div>
        </div>

        <div class="mt-7 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Jumlah Buku</p>
                <div class="mt-3 text-4xl font-extrabold text-slate-900">{{ $jumlahBuku }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Jumlah Anggota</p>
                <div class="mt-3 text-4xl font-extrabold text-slate-900">{{ $jumlahAnggota }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Peminjam</p>
                <div class="mt-3 text-4xl font-extrabold text-slate-900">{{ $totalPeminjam }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Sudah Dikembalikan</p>
                <div class="mt-3 text-4xl font-extrabold text-slate-900">{{ $sudahDikembalikan }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Belum Dikembalikan</p>
                <div class="mt-3 text-4xl font-extrabold text-slate-900">{{ $belumDikembalikan }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Terlambat</p>
                <div class="mt-3 text-4xl font-extrabold text-slate-900">{{ $terlambat }}</div>
            </div>
        </div>
    </div>
@endsection
