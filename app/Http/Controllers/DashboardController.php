<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function loginPost(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/');
        } else {
            return back()->with('pesan', "Email atau password salah");
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function dashboard()
    {
        $mhs = Mahasiswa::where('tahun', date('Y'))->get();
        $data = $this->rank($mhs);
        return view('dashboard', compact('data'));
    }
    public function history()
    {
        // get mahasiswa 3 tahun terakhir
        for($i=date("Y")-2; $i<=date("Y"); $i++) {
            $mhs = Mahasiswa::where('tahun', $i)->get();
            $data[$i] = $this->rank($mhs);
        }
        return view('history', compact('data'));
    }
    public function tambahData()
    {
        return view('tambah-data');
    }
    public function tambahDataPost(Request $request)
    {
        Mahasiswa::create($request->all());
        return back();
    }

    public function fuzzySugeno($data)
    {
        $mahasiswa = $data;
        // IPK
        $ipk = $this->countIpk($mahasiswa);
        // Lama Studi
        $lama_studi = $this->countLamaStudi($mahasiswa);
        // SK2PM
        $sk2pm = $this->countSk2pm($mahasiswa);
        // TOEFL
        $toefl = $this->countToefl($mahasiswa);

        $data = [];
        for ($i = 0; $i < count($mahasiswa); $i++) {
            $data[$i]['id'] = $mahasiswa[$i]->id;
            $data[$i]['nama'] = $mahasiswa[$i]->nama;
            $data[$i]['ipk'] = $ipk[$i];
            $data[$i]['lama_studi'] = $lama_studi[$i];
            $data[$i]['sk2pm'] = $sk2pm[$i];
            $data[$i]['toefl'] = $toefl[$i];
        }

        $bobot = [
            "sangat_tinggi" => 10,
            "tinggi" => 8,
            "sedang" => 6,
            "rendah" => 4,
            "sangat_rendah" => 2,
        ];

        $keluaran = [];
        $itt = 0;
        foreach ($data as $dt) {
            $keluaranTempPem = 0;
            $keluaranTempPen = 0;
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["rendah"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["rendah"], $dt["toefl"]["rendah"]) * $bobot["sangat_rendah"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["rendah"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["rendah"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["rendah"], $dt["toefl"]["tinggi"]) * $bobot["sangat_rendah"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["rendah"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["sedang"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["sedang"], $dt["toefl"]["rendah"]) * $bobot["sangat_rendah"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["sedang"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["sedang"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["sedang"], $dt["toefl"]["tinggi"]) * $bobot["rendah"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["sedang"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["tinggi"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["rendah"]) * $bobot["rendah"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["tinggi"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["tinggi"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["rendah"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["rendah"], $dt["toefl"]["rendah"]) * $bobot["rendah"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["rendah"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["rendah"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["rendah"], $dt["toefl"]["tinggi"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["rendah"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["sedang"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["sedang"], $dt["toefl"]["rendah"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["sedang"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["sedang"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["sedang"], $dt["toefl"]["tinggi"]) * $bobot["tinggi"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["sedang"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["tinggi"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["rendah"]) * $bobot["tinggi"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["rendah"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["tinggi"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["tinggi"]) * $bobot["tinggi"];
                $keluaranTempPen += min($dt['ipk']["rendah"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["rendah"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["rendah"], $dt["toefl"]["rendah"]) * $bobot["sangat_rendah"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["rendah"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["rendah"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["rendah"], $dt["toefl"]["tinggi"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["rendah"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["sedang"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["sedang"], $dt["toefl"]["rendah"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["sedang"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["sedang"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["sedang"], $dt["toefl"]["tinggi"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["sedang"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["tinggi"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["rendah"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["lama"] != 0 && $dt["sk2pm"]["tinggi"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["tinggi"]) * $bobot["tinggi"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["lama"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["rendah"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["rendah"], $dt["toefl"]["rendah"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["rendah"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["rendah"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["rendah"], $dt["toefl"]["tinggi"]) * $bobot["tinggi"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["rendah"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["sedang"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["sedang"], $dt["toefl"]["rendah"]) * $bobot["sedang"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["sedang"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["sedang"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["sedang"], $dt["toefl"]["tinggi"]) * $bobot["tinggi"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["sedang"], $dt["toefl"]["tinggi"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["tinggi"] != 0 && $dt["toefl"]["rendah"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["rendah"]) * $bobot["tinggi"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["rendah"]);
            }
            if ($dt['ipk']["tinggi"] != 0 && $dt["lama_studi"]["cepat"] != 0 && $dt["sk2pm"]["tinggi"] != 0 && $dt["toefl"]["tinggi"] != 0) {
                $keluaranTempPem += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["tinggi"]) * $bobot["sangat_tinggi"];
                $keluaranTempPen += min($dt['ipk']["tinggi"], $dt["lama_studi"]["cepat"], $dt["sk2pm"]["tinggi"], $dt["toefl"]["tinggi"]);
            }
            $hasil = $keluaranTempPem / $keluaranTempPen;
            $keluaran[$itt]["nama"] = $dt["nama"];
            $keluaran[$itt]['pem'] = $keluaranTempPem;
            $keluaran[$itt]['pen'] = $keluaranTempPen;
            $keluaran[$itt]['hasil'] = $hasil;
            $itt++;
        }

        $result = [];
        for ($i = 0; $i < count($mahasiswa); $i++) {
            $result[$i]['id'] = $mahasiswa[$i]->id;
            $result[$i]['nama'] = $mahasiswa[$i]->nama;
            $result[$i]['nim'] = $mahasiswa[$i]->nim;
            $result[$i]['prodi'] = $mahasiswa[$i]->prodi;
            $result[$i]['tahun'] = $mahasiswa[$i]->tahun;
            $result[$i]['ipk'] = $mahasiswa[$i]->ipk;
            $result[$i]['lama_studi'] = $mahasiswa[$i]->lama_studi;
            $result[$i]['sk2pm'] = $mahasiswa[$i]->sk2pm;
            $result[$i]['toefl'] = $mahasiswa[$i]->toefl;
            $result[$i]["nilai"] = $keluaran[$i]['hasil'];
        }

        return $result;
    }

    public function rank($data)
    {
        $data = $this->fuzzySugeno($data);
        usort($data, function ($a, $b) {
            return $a['nilai'] < $b['nilai'];
        });
        return $data;
    }

    public function countIpk($mahasiswa)
    {
        $nilai = [];

        foreach ($mahasiswa as $mhs) {
            $nilaiTemp = [];
            $nilaiTemp['nama'] = $mhs->nama;
            if ($mhs->ipk <= 3) {
                $nilaiTemp['rendah'] = 1;
                $nilaiTemp['tinggi'] = 0;
            } else if ($mhs->ipk > 3 && $mhs->ipk < 3.5) {
                $resultRendah = (3.5 - $mhs->ipk) / (3.5 - 3);
                $nilaiTemp['rendah'] = $resultRendah;

                $resultTinggi = ($mhs->ipk - 3) / (4 - 3);
                $nilaiTemp['tinggi'] = $resultTinggi;
            } else if ($mhs->ipk >= 3.5 && $mhs->ipk < 4) {
                $nilaiTemp['rendah'] = 0;
                $resultTinggi = ($mhs->ipk - 3) / (4 - 3);
                $nilaiTemp['tinggi'] = $resultTinggi;
            } else if ($mhs->ipk == 4) {
                $nilaiTemp['tinggi'] = 1;
                $nilaiTemp['rendah'] = 0;
            }
            $nilai[] = $nilaiTemp;
        }

        return $nilai;
    }

    public function countLamaStudi($mahasiswa)
    {
        $nilai = [];

        foreach ($mahasiswa as $mhs) {
            $nilaiTemp = [];

            if ($mhs->lama_studi <= 48) {
                $nilaiTemp['cepat'] = 1;
                $nilaiTemp['lama'] = 0;
            } else if ($mhs->lama_studi > 48 && $mhs->lama_studi < 56) {
                $resultCepat = (56 - $mhs->lama_studi) / (56 - 48);
                $nilaiTemp['cepat'] = $resultCepat;

                $resultLama = ($mhs->lama_studi - 48) / (72 - 48);
                $nilaiTemp['lama'] = $resultLama;
            } else if ($mhs->lama_studi >= 56 && $mhs->lama_studi < 72) {
                $nilaiTemp['cepat'] = 0;
                $resultLama = ($mhs->lama_studi - 48) / (72 - 48);
                $nilaiTemp['lama'] = $resultLama;
            } else if ($mhs->lama_studi >= 72) {
                $nilaiTemp['lama'] = 1;
                $nilaiTemp['cepat'] = 0;
            }
            $nilai[] = $nilaiTemp;
        }

        return $nilai;
    }

    public function countSk2pm($mahasiswa)
    {
        $nilai = [];

        foreach ($mahasiswa as $mhs) {
            $nilaiTemp = [];

            if ($mhs->sk2pm <= 3000) {
                $nilaiTemp['rendah'] = 1;
                $nilaiTemp['sedang'] = 0;
                $nilaiTemp['tinggi'] = 0;
            } else if ($mhs->sk2pm > 3000 && $mhs->sk2pm <= 5000) {
                $resultRendah = (5000 - $mhs->sk2pm) / (5000 - 3000);
                $nilaiTemp['rendah'] = $resultRendah;
                $nilaiTemp['sedang'] = 0;

                if ($mhs->sk2pm >= 4000 && $mhs->sk2pm <= 5000) {
                    $resultSedang = ($mhs->sk2pm - 4000) / (7000 - 4000);
                    $nilaiTemp['sedang'] = $resultSedang;
                }
                $nilaiTemp['tinggi'] = 0;
            } else if ($mhs->sk2pm > 5000 && $mhs->sk2pm <= 7000) {
                $nilaiTemp['rendah'] = 0;
                $resultSedang = ($mhs->sk2pm - 4000) / (7000 - 4000);
                $nilaiTemp['sedang'] = $resultSedang;
                $nilaiTemp['tinggi'] = 0;
            } else if ($mhs->sk2pm > 7000 && $mhs->sk2pm <= 9000) {
                $nilaiTemp['rendah'] = 0;
                $resultSedang = (10000 - $mhs->sk2pm) / (10000 - 7000);
                $nilaiTemp['sedang'] = $resultSedang;
                $nilaiTemp['tinggi'] = 0;
            } else if ($mhs->sk2pm > 9000) {
                $nilaiTemp['rendah'] = 0;
                $resultTinggi = ($mhs->sk2pm - 9000) / (12000 - 9000);
                $nilaiTemp['tinggi'] = $resultTinggi;
                $nilaiTemp['sedang'] = 0;
                if ($mhs->sk2pm > 9000 && $mhs->sk2pm <= 10000) {
                    $resultSedang = (10000 - $mhs->sk2pm) / (10000 - 7000);
                    $nilaiTemp['sedang'] = $resultSedang;
                }
                if ($mhs->sk2pm >= 12000) {
                    $nilaiTemp['tinggi'] = 1;
                }
            }
            $nilai[] = $nilaiTemp;
        }
        return $nilai;
    }

    public function countToefl($mahasiswa)
    {
        $nilai = [];

        foreach ($mahasiswa as $mhs) {
            $nilaiTemp = [];

            if ($mhs->toefl <= 300) {
                $nilaiTemp['rendah'] = 1;
                $nilaiTemp['tinggi'] = 0;
            } else if ($mhs->toefl > 300 && $mhs->toefl <= 500) {
                $resultRendah = (500 - $mhs->toefl) / (500 - 300);
                $nilaiTemp['rendah'] = $resultRendah;

                $resultTinggi = ($mhs->toefl - 400) / (677 - 400);
                $nilaiTemp['tinggi'] = $resultTinggi;
                if ($mhs->toefl < 400) {
                    $nilaiTemp['tinggi'] = 0;
                }
            } else if ($mhs->toefl > 500 && $mhs->toefl <= 677) {
                $nilaiTemp['rendah'] = 0;
                $resultTinggi = ($mhs->toefl - 400) / (677 - 400);
                $nilaiTemp['tinggi'] = $resultTinggi;
            }
            $nilai[] = $nilaiTemp;
        }
        return $nilai;
    }
}
