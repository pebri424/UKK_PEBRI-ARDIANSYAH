<?php

class SistemPeminjaman {
    private string $namaPeminjam;
    private string $namaAlat;
    private DateTime $tglPinjam;
    private DateTime $tglJatuhTempo;
    private int $tarifDendaPerHari;

    public function __construct(string $nama, string $namaAlat, string $tglPinjam, string $tglJatuhTempo, int $tarifDenda = 5000) {
        $this->namaPeminjam = $nama;
        $this->namaAlat = $namaAlat;
        $this->tglPinjam = new DateTime($tglPinjam);
        $this->tglJatuhTempo = new DateTime($tglJatuhTempo);
        $this->tarifDendaPerHari = $tarifDenda;
    }

    public function kembalikanAlat(string $tglKembaliAktualStr): array {
        $tglKembaliAktual = new DateTime($tglKembaliAktualStr);

        // Cek jika tanggal kembali melewati jatuh tempo
        if ($tglKembaliAktual > $this->tglJatuhTempo) {
            $selisih = $this->tglJatuhTempo->diff($tglKembaliAktual);
            $hariTerlambat = $selisih->days;
            $totalDenda = $hariTerlambat * $this->tarifDendaPerHari;

            return [
                "status" => "Terlambat",
                "hari_terlambat" => $hariTerlambat,
                "total_denda" => $totalDenda
            ];
        } else {
            return [
                "status" => "Tepat Waktu",
                "hari_terlambat" => 0,
                "total_denda" => 0
            ];
        }
    }

    public function getNamaPeminjam(): string {
        return $this->namaPeminjam;
    }
}

// --- Contoh Penggunaan ---

$peminjaman = new SistemPeminjaman("Budi", "Tenda Dome", "2023-10-01", "2023-10-08");
$hasil = $peminjaman->kembalikanAlat("2023-10-12"); // Terlambat 4 hari

echo "Peminjam: " . $peminjaman->getNamaPeminjam() . PHP_EOL;
echo "Status: " . $hasil['status'] . PHP_EOL;

if ($hasil['total_denda'] > 0) {
    echo "Keterlambatan: " . $hasil['hari_terlambat'] . " hari" . PHP_EOL;
    echo "Total Denda: Rp " . number_format($hasil['total_denda'], 0, ',', '.') . PHP_EOL;
}