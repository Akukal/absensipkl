@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    {{-- <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori Presensi</div>
        <div class="right"></div>
    </div> --}}
    <!-- * App Header -->

    <style>
    /* table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .hadir {
        color: green;
    }

    .tidak-hadir {
        color: red;
    }

    .izin {
        color: orange;
    }*/
    </style>
@endsection


@section('content')
    @php
        // Data dummy untuk histori absensi
        $bulan = $bulan ?? 6;
        $absen = [
            (object)[
                'tanggal' => '2024-06-01',
                'status' => 'Hadir',
                'jam_masuk' => null,
                'jam_keluar' => '07:52:00',
            ],
            (object)[
                'tanggal' => '2024-06-02',
                'status' => 'Tidak Hadir',
                
            ],
            (object)[
                'tanggal' => '2024-06-03',
                'status' => 'Izin',
                
            ],
            (object)[
                'tanggal' => '2024-06-04',
                'status' => 'Hadir',
                
            ],
            (object)[
                'tanggal' => '2024-06-05',
                'status' => 'Izin',
                
            ],
            (object)[
                'tanggal' => '2024-06-06',
                'status' => 'Hadir',
                
            ],
            (object)[
                'tanggal' => '2024-06-07',
                'status' => 'Izin',
                
            ],
            (object)[
                'tanggal' => '2024-06-08',
                'status' => 'Hadir',
                
            ],
            (object)[
                'tanggal' => '2024-06-09',
                'status' => 'Izin',
                
            ],
            (object)[
                'tanggal' => '2024-06-10',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-11',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-12',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-13',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-14',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-15',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-16',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-17',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-18',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-19',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-20',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-21',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-22',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-23',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-24',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-25',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-26',
                'status' => 'WFH',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-27',
                'status' => 'Hadir',
                'jam_masuk' => '06:00:00',
                'jam_keluar' => '07:52:00',
                
            ],
            (object)[
                'tanggal' => '2024-06-28',
                'status' => 'Hadir',
                'jam_masuk' => null,
                'jam_keluar' => '07:52:00',
            ]
        ];
        $akun = (object)[
            'nama' => 'DANENDRA RAHARDYAN DANARDI'
        ];
        $siswa = (object)[
            'kelas' => 'XII RPL 1'
        ];
        $perusahaan = (object)[
            'nama' => 'PT. Maju Jaya Abadi Pratama'
        ];
    @endphp
        <section class="w-full max-w-lg min-h-screen mx-auto flex flex-col justify-center gap-4 text-gray-300 py-24">
            <div class="w-full flex flex-col items-center justify-center gap-6 px-4">
                <div class="relative bg-gray-800 rounded-2xl shadow-2xl py-6 px-6 w-full max-w-md flex items-center gap-4 border border-gray-700">
                    <span class="inline-flex items-center justify-center w-20 h-20 bg-gray-700 rounded-full">
                        <ion-icon name="person-circle-outline" class="text-9xl text-white"></ion-icon>
                    </span>
                    <div>
                        @php
                            $namaAkun = $akun->nama;
                            $namaLength = mb_strlen($namaAkun);
                            $namaClass = $namaLength > 24 ? 'text-base' : 'text-lg';
                        @endphp
                        <h3 class="{{ $namaClass }} font-bold text-white mb-1">{{ $namaAkun }}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 mb-1">{{ $siswa->kelas }}</p>
                        <p class="text-xs sm:text-sm text-orange-400 font-semibold">{{ $perusahaan->nama }}</p>
                    </div>
                </div>
                <div class="relative bg-gray-800 rounded-2xl shadow-2xl py-6 px-6 w-full max-w-md flex flex-col items-center gap-4 border border-gray-700">
                    <form method="GET" class="w-full">
                        <select name="bulan" id="bulan" class="bg-gray-700 border border-gray-600 text-gray-300 text-sm rounded-lg focus:outline-none focus:border-orange-400 block w-full py-2.5 transition" onchange="this.form.submit()">
                            <option class="bg-gray-800 text-gray-300 border border-gray-700" value="6" {{ $bulan == 6 ? 'selected' : '' }}>Juni</option>
                            <option class="bg-gray-800 text-gray-300 border border-gray-700" value="7" {{ $bulan == 7 ? 'selected' : '' }}>Juli</option>
                            <option class="bg-gray-800 text-gray-300 border border-gray-700" value="8" {{ $bulan == 8 ? 'selected' : '' }}>Agustus</option>
                            <option class="bg-gray-800 text-gray-300 border border-gray-700" value="9" {{ $bulan == 9 ? 'selected' : '' }}>September</option>
                            <option class="bg-gray-800 text-gray-300 border border-gray-700" value="10" {{ $bulan == 10 ? 'selected' : '' }}>Oktober</option>
                            <option class="bg-gray-800 text-gray-300 border border-gray-700" value="11" {{ $bulan == 11 ? 'selected' : '' }}>November</option>
                            <option class="bg-gray-800 text-gray-300 border border-gray-700" value="12" {{ $bulan == 12 ? 'selected' : '' }}>Desember</option>
                        </select>
                    </form>
                    <div class="overflow-x-auto w-full rounded-lg border border-gray-700">
                        <table class="min-w-full text-sm text-left text-gray-400 rounded-lg bg-gray-800">
                            <thead class="text-xs uppercase bg-gray-700 text-gray-300 text-center">
                                <tr>
                                    <th scope="col" class="px-2 py-2 w-10">No</th>
                                    <th scope="col" class="px-2 py-2">Tanggal</th>
                                    <th scope="col" class="px-2 py-2">Status</th>
                                    <th scope="col" class="px-2 py-2">Jam Masuk</th>
                                    <th scope="col" class="px-2 py-2">Jam Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absen as $key => $item)
                                    <tr class="{{ $key % 2 ? 'bg-gray-700/30' : 'bg-gray-800' }} border-b border-gray-700">
                                        <td class="px-2 py-2 text-center">{{ $key+1 }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap">{{ $item->tanggal }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <span class="
                                                @if($item->status=='Hadir') text-green-400 font-semibold 
                                                @elseif($item->status=='WFH') text-blue-400 font-semibold 
                                                @elseif($item->status=='Izin') text-orange-400 font-semibold 
                                                @else text-red-400 font-semibold @endif">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{ $item->status == 'Izin' ? '--:--:--' : ($item->jam_masuk ?? '--:--:--') }}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{ $item->status == 'Izin' ? '--:--:--' : ($item->jam_keluar ?? '--:--:--') }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($absen) == 0)
                                    <tr>
                                        <td colspan="5" class="px-2 py-4 text-center text-gray-400 italic">Belum ada data presensi bulan ini</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>

    {{-- <div class="section" id="user-section">
        <div id="user-detail" style="margin-top: 55px">
            <div id="user-info">
                <h3 id="user-name">{{ Auth::user()->nama ?? 'hi' }}</h3>
                <span id="user-role">{{ $siswa->kelas }}</span>
                <p style="margin-top: 15px">
                    <span id="user-role">{{ $perusahaan->nama }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="row" style="margin-top:14px">
                <div class="col-10">
                    <form method="GET">        
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control selectmaterialize" onchange="this.form.submit()">
                                <option value="6" {{ $bulan == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ $bulan == 7 ? 'selected' : '' }}>Juli</option>
                                <option value="8" {{ $bulan == 8 ? 'selected' : '' }}>Agustus</option>
                                <option value="9" {{ $bulan == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $bulan == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ $bulan == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $bulan == 12 ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <ion-icon name="search"></ion-icon>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table>
        <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        </tr>
        @php $no = 1; @endphp
        @foreach ($absen as $item)
        <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $item->tanggal }}</td>
        <td class="{{ $item->status == 'Hadir' ? 'hadir' : ($item->status == 'Izin' ? 'izin' : 'tidak-hadir') }}">{{ $item->status }}</td>
        </tr>
        @endforeach
    </table>
    <div class="row mt-2" style="position: fixed; width:100%; margin:auto; overflow-y:scroll; height:430px">
        <div class="col" id="showhistori"></div>
    </div>--}}
@endsection
