<?php

namespace App\Controllers;

use ocs\spklib\Wplib as wp;
use ocs\spklib\Moora as moora;

class Spk extends BaseController
{
    public function index()
    {
        $kriteria = [
            [
                'nama' => 'Bahan Pembuatan',
                'kode' => 'C1',
                'bobot' => 2.2,
                'type' => 'Benefits'
            ],
            [
                'nama' => 'Pengaturan Suhu',
                'kode' => 'C2',
                'bobot' => 2.1,
                'type' => 'Benefits'
            ],
            [
                'nama' => 'Garansi',
                'kode' => 'C3',
                'bobot' => 2.1,
                'type' => 'Benefits'
            ],
            [
                'nama' => 'Harga',
                'kode' => 'C4',
                'bobot' => 1.8,
                'type' => 'Cost'
            ],
            [
                'nama' => 'Ukuran',
                'kode' => 'C5',
                'bobot' => 1.8,
                'type' => 'Cost'
            ]
        ];
        $alternatif = [
            [
                "nama" => "Nama1",
                "nilai" => [
                    [
                        "kode" => "C1",
                        "bobot" => 40
                    ],
                    [
                        "kode" => "C2",
                        "bobot" => 50
                    ],
                    [
                        "kode" => "C3",
                        "bobot" => 50
                    ],
                    [
                        "kode" => "C4",
                        "bobot" => 40
                    ],
                    [
                        "kode" => "C5",
                        "bobot" => 30
                    ]
                ]
            ], 
            [
                "nama" => "Nama2",
                "nilai" => [
                    [
                        "kode" => "C1",
                        "bobot" => 30
                    ],
                    [
                        "kode" => "C2",
                        "bobot" => 20
                    ],
                    [
                        "kode" => "C3",
                        "bobot" => 30
                    ],
                    [
                        "kode" => "C4",
                        "bobot" => 50
                    ],
                    [
                        "kode" => "C5",
                        "bobot" => 50
                    ]
                ]
            ], 
            [
                "nama" => "Nama3",
                "nilai" => [
                    [
                        "kode" => "C1",
                        "bobot" => 20
                    ],
                    [
                        "kode" => "C2",
                        "bobot" => 20
                    ],
                    [
                        "kode" => "C3",
                        "bobot" => 30
                    ],
                    [
                        "kode" => "C4",
                        "bobot" => 50
                    ],
                    [
                        "kode" => "C5",
                        "bobot" => 40
                    ]
                ]
            ], 
            [
                "nama" => "Nama4",
                "nilai" => [
                    [
                        "kode" => "C1",
                        "bobot" => 20
                    ],
                    [
                        "kode" => "C2",
                        "bobot" => 20
                    ],
                    [
                        "kode" => "C3",
                        "bobot" => 30
                    ],
                    [
                        "kode" => "C4",
                        "bobot" => 50
                    ],
                    [
                        "kode" => "C5",
                        "bobot" => 40
                    ]
                ]
            ], 
            [
                "nama" => "Nama5",
                "nilai" => [
                    [
                        "kode" => "C1",
                        "bobot" => 40
                    ],
                    [
                        "kode" => "C2",
                        "bobot" => 50
                    ],
                    [
                        "kode" => "C3",
                        "bobot" => 30
                    ],
                    [
                        "kode" => "C4",
                        "bobot" => 40
                    ],
                    [
                        "kode" => "C5",
                        "bobot" => 30
                    ]
                ]
            ]
        ];

        $a = new wp($kriteria, $alternatif, 0);
        $b = $a->ranking;
        $c = new moora($kriteria, $alternatif, 0);
        // return $this->respond($a->ranking);
        return $this->respond($c);
        // echo json_encode($a->ranking);
    }
}
