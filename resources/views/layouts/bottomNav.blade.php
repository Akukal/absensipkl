<!-- App Bottom Menu -->
<div class="appBottomMenu">
    <a href="/home" class="item {{ $title == 'Home' ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="/option" class="item {{ $title == 'Absen' || $title == 'Izin' || $title == 'Absensi' ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="camera-outline"></ion-icon>
            <strong>Absen</strong>  
        </div>
    </a>
    <a href="/histori" class="item {{ $title == 'Histori' ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated" aria-label="document text outline">
            </ion-icon>
            <strong>Histori</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->
