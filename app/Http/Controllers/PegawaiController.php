<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        // Data dasar
        $nama = "M. Dzakwan Syafiq";
        $tanggalLahir = date_create('2006-05-29');
        $hobi = ["Membaca", "Bermain Game", "Olahraga", "Traveling", "Fotografi", "Memasak"];
        $tglHarusWisuda = date_create('2028-08-25');
        $currentSemester = 3;

        // Hitung umur
        $umur = $this->hitungUmur($tanggalLahir);

        // Hitung jarak hari dari tgl_harus_wisuda
        $hariIni = date_create();
        $jarakHari = $this->hitungJarakHari($hariIni, $tglHarusWisuda);

        // Pesan semester
        if ($currentSemester < 3) {
            $pesanSemester = "Masih Awal, Kejar TAK";
        } else {
            $pesanSemester = "Jangan main-main, kurang-kurangi main game!";
        }

        // Cita-cita
        $citaCita = "Menjadi Data Analysis Profesional Dan Dapat Membanggakan Orang tua";

        // Data untuk view
        $data = [
            'name' => $Snama,
            'my_age' => $umur,
            'hobbies' => $hobi,
            'tgl_harus_wisuda' => date_format($tglHarusWisuda, 'd-m-Y'),
            'time_to_study_left' => $jarakHari,
            'current_semester' => $currentSemester,
            'semester_message' => $pesanSemester,
            'future_goal' => $citaCita
        ];

        return view('halaman-pegawai', compact('data'));
    }

    // Menghitung umur dari tanggal lahir
    private function hitungUmur($tanggalLahir)
    {
        $hariIni = date_create();
        $selisih = date_diff($tanggalLahir, $hariIni);
        return $selisih->y;
    }

    // Menghitung jarak hari antara dua tanggal
    private function hitungJarakHari($dari, $ke)
    {
        $selisih = date_diff($dari, $ke);

        if ($dari > $ke) {
            return -$selisih->days;
        }

        return $selisih->days;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
