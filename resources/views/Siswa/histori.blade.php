@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <style>
    table {
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
    }
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
            'keterangan' => 'Masuk - WFO'
        ],
        (object)[
            'tanggal' => '2024-06-02',
            'status' => 'Tidak Hadir',
            'keterangan' => 'Tanpa Keterangan'
        ],
        (object)[
            'tanggal' => '2024-06-03',
            'status' => 'Izin',
            'keterangan' => 'Izin Sakit'
        ],
        (object)[
            'tanggal' => '2024-06-04',
            'status' => 'Hadir',
            'keterangan' => 'Masuk - WFH'
        ],
        (object)[
            'tanggal' => '2024-06-05',
            'status' => 'Hadir',
            'keterangan' => 'Masuk - WFO'
        ]
    ];
    $siswa = (object)[
        'kelas' => 'XII TKJ 2'
    ];
    $perusahaan = (object)[
        'nama' => 'PT. Pintar Berjaya Digital'
    ];
@endphp 
<div class="section" id="user-section">
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
                            <select name="bulan" id="bulan" class="form-control selectmaterialize">
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
        <?php $no = 1; ?>
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
    </div>
@endsection
