<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mahasiswa::create([
            "nama" => "Rizki",
            "nim" => "10191023",
            "prodi" => "Teknik Informatika",
            "ipk" => 3.72,
            "tahun" => "2017",
            "lama_studi" => 73,
            "sk2pm" => 14000,
            "toefl" => 520,
        ]);
        Mahasiswa::create([
            "nama" => "Rizal",
            "nim" => "10191042",
            "prodi" => "Teknik Informatika",
            "ipk" => 3.74,
            "tahun" => "2018",
            "lama_studi" => 52,
            "sk2pm" => 4500,
            "toefl" => 420,
        ]);
        Mahasiswa::create([
            "nama" => "Rashka",
            "nim" => "10191021",
            "prodi" => "Teknik Informatika",
            "tahun" => "2019",
            "ipk" => 3.21,
            "lama_studi" => 60,
            "sk2pm" => 9350,
            "toefl" => 420,
        ]);
        Mahasiswa::create([
            "nama" => "Feri",
            "nim" => "10191043",
            "prodi" => "Teknik Informatika",
            "tahun" => "2020",
            "ipk" => 3.91,
            "lama_studi" => 52,
            "sk2pm" => 11500,
            "toefl" => 420,
        ]);
        Mahasiswa::create([
            "nama" => "Arya",
            "nim" => "10191012",
            "prodi" => "Teknik Informatika",
            "tahun" => "2021",
            "ipk" => 2.42,
            "lama_studi" => 72,
            "sk2pm" => 7500,
            "toefl" => 542,
        ]);

        $prodi = [
            "Teknik Informatika", "Sistem Informasi", "Teknik Industri", "Teknik Lingkungan", "Teknik Perkapalan", "Teknik Kelautan", "Matematika", "Aktuaria", "Arsitektur", "Teknik Sipil", "Perancanaan Wilayah dan Kota", "Fisika", "Teknik Kimia", "Teknik Mesin", "Teknik Elektro"
        ];
        $ipk = [
            2.00, 2.01, 2.02, 2.03, 2.04, 2.05, 2.06, 2.07, 2.08, 2.09, 2.10, 2.11, 2.12, 2.13, 2.14, 2.15, 2.16, 2.17, 2.18, 2.19, 2.20, 2.21, 2.22, 2.23, 2.24, 2.25, 2.26, 2.27, 2.28, 2.29, 2.30, 2.31, 2.32, 2.33, 2.34, 2.35, 2.36, 2.37, 2.38, 2.39, 2.40, 2.41, 2.42, 2.43, 2.44, 2.45, 2.46, 2.47, 2.48, 2.49, 2.50, 2.51, 2.52, 2.53, 2.54, 2.55, 2.56, 2.57, 2.58, 2.59, 2.60, 2.61, 2.62, 2.63, 2.64, 2.65, 2.66, 2.67, 2.68, 2.69, 2.70, 2.71, 2.72, 2.73, 2.74, 2.75, 2.76, 2.77, 2.78, 2.79, 2.80, 2.81, 2.82, 2.83, 2.84, 2.85, 2.86, 2.87, 2.88, 2.89, 2.90, 2.91, 2.92, 2.93, 2.94, 2.95, 2.96, 2.97, 2.98, 2.99, 3.00, 3.01, 3.02, 3.03, 3.04, 3.05, 3.06, 3.07, 3.08, 3.09, 3.10, 3.11, 3.12, 3.13, 3.14, 3.15, 3.16, 3.17, 3.18, 3.19, 3.20, 3.21, 3.22, 3.23, 3.24, 3.25, 3.26, 3.27, 3.28, 3.29, 3.30, 3.31, 3.32, 3.33, 3.34, 3.35, 3.36, 3.37, 3.38, 3.39, 3.40, 3.41, 3.42, 3.43, 3.44, 3.45, 3.46, 3.47, 3.48, 3.49, 3.50, 3.51, 3.52, 3.53, 3.54, 3.55, 3.56, 3.57, 3.58, 3.59, 3.60, 3.61, 3.62, 3.63, 3.64, 3.65, 3.66, 3.67, 3.68, 3.69, 3.70, 3.71, 3.72, 3.73, 3.74, 3.75, 3.76, 3.77, 3.78, 3.79, 3.80, 3.81, 3.82, 3.83, 3.84, 3.85, 3.86, 3.87, 3.88, 3.89, 3.90, 3.91, 3.92, 3.93, 3.94, 3.95, 3.96, 3.97, 3.98, 3.99, 4.00
        ];
        $tahun = [
            "2017", "2018", "2019", "2020", "2021", "2022"
        ];
        for ($i = 1; $i <= 200; $i++) {
            Mahasiswa::create([
                "nama" => "Mahasiswa " . $i,
                "nim" => "101910" . $i,
                "tahun" => $tahun[rand(0, 5)],
                "prodi" => $prodi[rand(0, count($prodi) - 1)],
                "ipk" => $ipk[rand(0, count($ipk) - 1)],
                "lama_studi" => rand(42, 96),
                "sk2pm" => rand(1000, 20000),
                "toefl" => rand(100, 677),
            ]);
        }
    }
}
