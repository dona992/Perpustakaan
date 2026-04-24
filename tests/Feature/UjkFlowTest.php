<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UjkFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_input_pages_can_be_opened(): void
    {
        $this->get('/anggota/create')->assertOk();
        $this->get('/buku/create')->assertOk();
        $this->get('/peminjaman/create')->assertOk();
    }

    public function test_can_store_anggota(): void
    {
        $response = $this->post('/anggota', [
            'nomor_induk' => 'A001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka No. 10, Bandung',
        ]);

        $response->assertRedirect('/anggota');

        $this->assertDatabaseHas('anggota', [
            'nomor_induk' => 'A001',
            'nama' => 'Budi Santoso',
        ]);
    }

    public function test_can_store_buku(): void
    {
        $response = $this->post('/buku', [
            'judul' => 'Belajar Laravel',
            'pengarang' => 'Andi Pratama',
            'penerbit' => 'Informatika',
            'tahun' => 2024,
        ]);

        $response->assertRedirect('/buku');

        $this->assertDatabaseHas('buku', [
            'judul' => 'Belajar Laravel',
            'pengarang' => 'Andi Pratama',
        ]);
    }

    public function test_can_store_peminjaman(): void
    {
        $anggota = Anggota::create([
            'nomor_induk' => 'A002',
            'nama' => 'Siti Aminah',
            'alamat' => 'Jl. Anggrek No. 2, Jakarta',
        ]);

        $buku = Buku::create([
            'judul' => 'Algoritma Dasar',
            'pengarang' => 'Rina Putri',
            'penerbit' => 'Erlangga',
            'tahun' => 2022,
        ]);

        $response = $this->post('/peminjaman', [
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-04-23',
            'tanggal_kembali' => '2026-04-30',
            'status' => 'dipinjam',
        ]);

        $response->assertRedirect('/peminjaman');

        $this->assertDatabaseHas('peminjaman', [
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'status' => 'dipinjam',
        ]);
    }

    public function test_peminjaman_validation_rejects_invalid_status(): void
    {
        $anggota = Anggota::create([
            'nomor_induk' => 'A003',
            'nama' => 'Rudi',
            'alamat' => 'Jl. Kenanga No. 7',
        ]);

        $buku = Buku::create([
            'judul' => 'Basis Data',
            'pengarang' => 'Dewi',
            'penerbit' => 'Gramedia',
            'tahun' => 2020,
        ]);

        $response = $this->from('/peminjaman')->post('/peminjaman', [
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-04-23',
            'tanggal_kembali' => '2026-04-30',
            'status' => 'hilang',
        ]);

        $response->assertRedirect('/peminjaman');
        $response->assertSessionHasErrors('status');
    }
}
