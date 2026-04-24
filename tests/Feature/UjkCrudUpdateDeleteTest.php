<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UjkCrudUpdateDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_and_delete_anggota(): void
    {
        $anggota = Anggota::create([
            'nomor_induk' => 'A100',
            'nama' => 'Nama Lama',
            'alamat' => 'Alamat Lama',
        ]);

        $update = $this->put("/anggota/{$anggota->id}", [
            'nomor_induk' => 'A100',
            'nama' => 'Nama Baru',
            'alamat' => 'Alamat Baru',
        ]);

        $update->assertRedirect('/anggota');
        $this->assertDatabaseHas('anggota', [
            'id' => $anggota->id,
            'nama' => 'Nama Baru',
        ]);

        $delete = $this->delete("/anggota/{$anggota->id}");
        $delete->assertRedirect('/anggota');
        $this->assertDatabaseMissing('anggota', ['id' => $anggota->id]);
    }

    public function test_cannot_delete_anggota_if_related_peminjaman_exists(): void
    {
        $anggota = Anggota::create([
            'nomor_induk' => 'A150',
            'nama' => 'Anggota Dipakai',
            'alamat' => 'Jl. Melati',
        ]);

        $buku = Buku::create([
            'judul' => 'Buku Relasi',
            'pengarang' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun' => 2023,
        ]);

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-04-23',
            'tanggal_kembali' => null,
            'status' => 'dipinjam',
        ]);

        $delete = $this->delete("/anggota/{$anggota->id}");

        $delete->assertRedirect('/anggota');
        $delete->assertSessionHas('error');
        $this->assertDatabaseHas('anggota', ['id' => $anggota->id]);
    }

    public function test_can_update_and_delete_buku(): void
    {
        $buku = Buku::create([
            'judul' => 'Judul Lama',
            'pengarang' => 'Pengarang Lama',
            'penerbit' => 'Penerbit Lama',
            'tahun' => 2021,
        ]);

        $update = $this->put("/buku/{$buku->id}", [
            'judul' => 'Judul Baru',
            'pengarang' => 'Pengarang Baru',
            'penerbit' => 'Penerbit Baru',
            'tahun' => 2022,
        ]);

        $update->assertRedirect('/buku');
        $this->assertDatabaseHas('buku', [
            'id' => $buku->id,
            'judul' => 'Judul Baru',
        ]);

        $delete = $this->delete("/buku/{$buku->id}");
        $delete->assertRedirect('/buku');
        $this->assertDatabaseMissing('buku', ['id' => $buku->id]);
    }

    public function test_can_update_and_delete_peminjaman(): void
    {
        $anggota = Anggota::create([
            'nomor_induk' => 'A200',
            'nama' => 'Budi',
            'alamat' => 'Jl. Mawar',
        ]);

        $buku = Buku::create([
            'judul' => 'Laravel Dasar',
            'pengarang' => 'Andi',
            'penerbit' => 'Informatika',
            'tahun' => 2024,
        ]);

        $peminjaman = Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-04-23',
            'tanggal_kembali' => '2026-04-27',
            'status' => 'dipinjam',
        ]);

        $update = $this->put("/peminjaman/{$peminjaman->id}", [
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-04-23',
            'tanggal_kembali' => '2026-04-28',
            'status' => 'dikembalikan',
        ]);

        $update->assertRedirect('/peminjaman');
        $this->assertDatabaseHas('peminjaman', [
            'id' => $peminjaman->id,
            'status' => 'dikembalikan',
        ]);

        $delete = $this->delete("/peminjaman/{$peminjaman->id}");
        $delete->assertRedirect('/peminjaman');
        $this->assertDatabaseMissing('peminjaman', ['id' => $peminjaman->id]);
    }
}
