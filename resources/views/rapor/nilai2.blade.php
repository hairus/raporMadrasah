<style>
    table {
        border-collapse: collapse;
    }

    #border {
        border: 1px solid black;
    }
</style>
<table width="100%">
    <tbody>
    <tr>
        <td width="20%">NAMA MDT</td>
        <td width="1%">:</td>
        <td width="35%">Darul Mustafa</td>
        <td width="1%">&nbsp;</td>
        <td width="18%">TAHUN PELAJARAN</td>
        <td width="1%">:</td>
        <td width="24%">Semester {{ $smt->smt }} - ({{ $smt->tapel }})</td>
    </tr>
    <tr>
        <td>ALAMAT</td>
        <td>:</td>
        <td>{{ $siswa->almt }}</td>
        <td>&nbsp;</td>
        <td>NOMER INDUK</td>
        <td>:</td>
        <td>{{ $siswa->nis }}</td>
    </tr>
    </tbody>
    <tbody>
    <tr>
        <td>NAMA MURID</td>
        <td>:</td>
        <td>{{ $siswa->nama }}</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>KELAS</td>
        <td>:</td>
        <td>{{ $siswa->kls }}</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>
<br>
<table width="100%" border="1" id="border">
    <tbody>
    <tr>
        <td width="14%" rowspan="2" align="center">NO</td>
        <td width="19%" rowspan="2" align="center">MATA PELAJARAN</td>
        <td colspan="2" align="center">NILAI PRESTASI</td>
        <td width="26%" rowspan="2" align="center">Nilai Rata-Rata Kelas</td>
    </tr>
    <tr>
        <td width="24%" align="center">Angka</td>
        <td width="17%" align="center">Huruf</td>
    </tr>
    <?php
    $no = 1;
    ?>
    @foreach($mapel as $data)
        <tr>
            <td align="center">{{ $no++ }}</td>
            <td align="center">{{ $data->mapels->mapel}}</td>
            @foreach($nilai->where('mapel_id', $data->mapel_id) as $nilais)
                <td align="center">{{ $nilais->nilai }}</td>
            @endforeach
            @foreach($nilai->where('mapel_id', $data->mapel_id) as $gg)
                @if($gg->nilai >= 85)
                    <td align="center">A</td>
                @elseif($gg->nilai >= 75)
                    <td align="center">B</td>
                @elseif($gg->nilai >= 60)
                    <td align="center">C</td>
                @elseif($gg->nilai >= 50)
                    <td align="center">D</td>
                @else
                    <td align="center">E</td>
                @endif
            @endforeach
            <td align="center">{{ round($rata->where('mapel_id', $data->mapel_id)->avg('nilai')) }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2" align="center">Jumlah Rerata</td>
        <td align="center">{{ round($rataAnak) }}</td>
        <td></td>
        <td align="center"></td>
    </tr>
    </tbody>
</table>
<br>
<table width="100%" border="1">
    <tbody>
    <tr>
        <td width="34%"><b>Rangking</b></td>
        <td width="20%" style="text-align: center"><b>{{ $na->ranking }}</b></td>
    </tr>
    <tr>
        <td>Kepribadian</td>
        <td>1. Kelakuan</td>
        @if($kep)
            <td align="center">{{ $kep->kelakuan }}</td>
        @endif
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>2. Kerajinan</td>
        @if($kep)
            <td align="center">{{ $kep->kerajinan }}</td>
        @endif
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>3. Kebersihan</td>
        @if($kep)
            <td align="center">{{ $kep->kebersihan }}</td>
        @endif
    </tr>
    <tr>
        {{-- <td colspan="3">Peringkat Kelas Ke ..... dari ..... Murid</td> --}}
    </tr>
    </tbody>
</table>
<br>
<table width="100%" border="1">
    <tbody>
    <tr>
        <td width="31%">ketidak Hadiran</td>
        <td width="69%">1. sakit( {{$sakit}} ) hari</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>2. Izin ( {{ $ijin }} ) Hari</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>3. Tanpa Keterangan ( {{ $alpa }} ) Hari</td>
    </tr>
    <tr>
        <td colspan="2">
            <p>Catatan Untuk di perhatikan</p>
            <p>&nbsp;</p>
        </td>
    </tr>
    </tbody>
</table>
<br>
<table width="100%">
    <tbody>
    <tr>
        <td width="8%">Di berikan</td>
        <td width="1%">:</td>
        <td width="44%">Sumenep</td>
        <td width="47%"><strong>Keputusan :</strong></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td>{{$tgl->tgl_rapor}}</td>
        <td>Dengan Memperhatikan Hasil Yang Di Capai Pada Semester I Dan II Maka Murid ini Ditetapkan :</td>
    </tr>
    @if($rataAnak >= 59)
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

            <td>
                @if($siswa->kls == 6)
                    <strong>Lulus</strong>
                @else
                    <strong>Naik ke Kelas {{ $siswa->kls +1 }}</strong>
                @endif
            </td>
        </tr>
    @else
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Tinggal di Kelas {{ $siswa->kls }}</strong></td>
        </tr>
    @endif
    </tbody>
</table>
<br>
<table width="100%">
    <tbody>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td align="center">
            <p>Mengetahui</p>
            <p>Orang Tua/ Wali</p>
            <p>&nbsp;</p>
            <p>
                @if($siswa->na)
                    <strong><u>{{ $siswa->na }}</u></strong>
                @elseif($siswa->ni)
                    <strong><u>{{ $siswa->ni }}</u></strong>
                @else
                    <strong><u>{{ $siswa->wali }}</u></strong>
                @endif
            </p>
        </td>
        <td align="center">
            <p>&nbsp;</p>
            <p>Wali Kelas</p>
            <p>&nbsp;</p>
            <p><strong><u>{{ $wali->nama }}</u></strong></p>
        </td>
        <td align="center">
            <p>&nbsp;</p>
            <p>Kepala MDT</p>
            <p>&nbsp;</p>
            <p><strong><u>MUH. ABDUL MUN IM, S.PdI</u></strong>
                <u>
            </p>
            </u></p>
        </td>
    </tr>
    </tbody>
</table>
