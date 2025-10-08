@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Status Kehadiran</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="row" style="margin-top:70px">
                <div class="col-12">
                  <div class="card mb-1 clickable-card" style="border : 1px solid blue">
                    <a href="/create">  <div class="card-body">
                        <div class="historicontent">
                          <div class="iconpresensi">
                            <ion-icon name="accessibility-outline" style="font-size: 48px;" class="text-success"></ion-icon>
                          </div>
                          <div class="datapresensi">
                            <h3 style="line-height: 3px">HADIR</h3>
                            <span>Jam Masuk : 07.00</span><br>
                            <span>Jam Pulang : 16.00</span>
                          </div>
                        </div>
                      </div>
                    </a>  </div>
                </div>
                <div class="col-12">
                  <div class="card mb-1 clickable-card" style="border : 1px solid blue">
                    <a href="/izin">  <div class="card-body">
                        <div class="historicontent">
                          <div class="iconpresensi">
                            <ion-icon name="ban-outline" style="font-size: 48px;" class="text-danger"></ion-icon>
                          </div>
                          <div class="datapresensi">
                            <h3 style="line-height: 3px">TIDAK HADIR</h3>
                            <span>Lampirkan Surat Izin</span><br>
                            <span>Serta Keterangan</span>
                          </div>
                        </div>
                      </div>
                    </a>  </div>
                </div>
              </div>
              
        </div>
    </div>
@endsection
