<table>
    <thead>
    <tr>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">No</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Tanggal</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Nama</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Kelas</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Perusahaan</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Pembimbing</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Status</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Jam Masuk</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Jam Keluar</th>
        <th style="font-family: calibri; font-size: 12px; text-align: center; border: 1px solid black; background-color: yellow;">Keterangan</th>
    </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
    @foreach($data as $item)
    
        <tr>
            <td style="border: 1px solid black;" >{{ $no++ }}</td>
            <td style="border: 1px solid black;">{{ $item->tanggal }}</td>
            <td style="border: 1px solid black;">{{ $item->siswa->user->nama }}</td>
            <td style="border: 1px solid black;">{{ $item->siswa->kelas }}</td>
            <td style="border: 1px solid black;">{{ $item->siswa->perusahaan->nama }}</td>
            <td style="border: 1px solid black;">{{ $item->siswa->perusahaan->guru->user->nama }}</td>
            <td style="border: 1px solid black; background-color:{{ $item->status == 'Hadir' ? 'greenyellow' : ($item->status == 'Izin' ? 'orange' : 'red') }}">{{ $item->status }}</td>
            @if($item->status == 'Izin')
            <td style="border: 1px solid black; background-color: orange">Izin</td>
            <td style="border: 1px solid black; background-color: orange">Izin</td>
            @else
            <td style="border: 1px solid black; {{ $item->jam_masuk == null ? 'background-color: red' : '' }}">{{ $item->jam_masuk == null ? 'Belum Absen' : $item->jam_masuk }}</td>
            <td style="border: 1px solid black; {{ $item->jam_keluar == null ? 'background-color: red' : '' }}">{{ $item->jam_keluar == null ? 'Belum Absen' : $item->jam_keluar }}</td>
            @endif

            @if ($item->keterangan == null)
            <td style="border: 1px solid black; background-color:greenyellow">Tidak Izin</td>
            @else
            <td style="border: 1px solid black;">{{ $item->keterangan }}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
