@extends('layout.master')
@section('title', 'Lapor Izin Absen')
@section('description', 'Lapor Izin Absen')
@section('icon', 'pe-7s-note2')

@section('page-content')
<div class="row justify-content-center mt-5">
    <picture class="pull-left">
        <img class="img-fluid" src="{{ asset('assets/images/webart/webart-absensi.png')}}" style="max-height: 500px;" alt="Foto Circle 1">
    </picture>
    <div class="col-md-12 col-lg-6 col-xl-5 ml-3 container-centered">
        <div class="w-100 mb-3 card">
            <div class="card-header-tab card-header-tab-animation card-header">
                <div class="card-header-title">
                    <i class="header-icon pe-7s-note2 icon-gradient bg-love-kiss"></i>
                    Lapor Izin Absen
                </div>
            </div>
            <div class="card-body">
                <p>Disini anda bisa melaporkan izin untuk absensi, <br/>dengan mengisi form dibawah ini akan langsung ter-rekor di database.</p>
                <form id="form-create-izin" action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="position-relative row form-group"><label for="keterangan" class="col-sm-2 col-form-label">Keterangan Izin</label>
                        <div class="col-sm-10"><textarea name="keterangan" id="keterangan" placeholder="Alasan untuk Izin" type="keterangan" class="form-control" required></textarea></div>
                    </div>
                    @error('keterangan')
                    <div class="position-relative row form-group"><label for="keterangan" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="photo" class="col-sm-2 col-form-label">Foto Izin</label>
                        <div class="col-sm-8">
                            <input name="photo" id="photo" accept="image/*" type="file" class="form-control" required>
                        </div>
                    </div>
                    @error('photo')
                    <div class="position-relative row form-group"><label for="photo" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="tanggal_izin" class="col-sm-2 col-form-label">Tanggal Izin</label>
                        <div class="col-sm-8"><input name="tanggal_izin" id="tanggal_izin" type="tanggal_izin" class="datepicker form-control" required></div>
                    </div>
                    @error('tanggal_izin')
                    <div class="position-relative row form-group"><label for="tanggal_izin" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="sampai_tanggal" class="col-sm-2 col-form-label">Sampai Tanggal</label>
                        <div class="col-sm-8"><input name="sampai_tanggal" id="sampai_tanggal" type="sampai_tanggal" class="datepicker form-control" required></div>
                    </div>
                    @error('sampai_tanggal')
                    <div class="position-relative row form-group"><label for="sampai_tanggal" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="dropdown-divider mb-3"></div>
                    <div class="position-relative row form-check">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="col-md-6 btn-transition btn btn-outline-warning">
                                <i class="pe-7s-paper-plane"></i>
                                <strong>
                                    Kirim
                                </strong>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-12 col-xl-12 ml-3">
    <div class="mb-3 card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <i class="header-icon pe-7s-note2 icon-gradient bg-love-kiss"></i>
                Laporan Izin Sebelumnya
            </div>
        </div>
        <div class="card-body">
            <table class="table w-100">
                <thead>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Foto</th>
                </thead>
                <tbody>
                    @if (count($data_izin) == 0)
                    <tr>
                        <td class="bg-light text-secondary text-center" colspan="4">Belum ada laporan izin absen.</td>
                    </tr>
                    @else
                        @foreach ($data_izin as $izin)
                            @if ($izin->approval == 1)
                            <tr class="bg-success text-white">
                            @elseif ($izin->approval == 2)
                            <tr class="bg-danger text-white">
                            @else
                            <tr>
                            @endif
                                <td style="font-size: 40px;">
                                    @if ($izin->approval == 1)
                                    <i class="metismenu-icon pe-7s-check"></i>
                                    @elseif ($izin->approval == 2)
                                    <i class="metismenu-icon pe-7s-close-circle"></i>
                                    @else
                                    <i class="metismenu-icon pe-7s-note2"></i>
                                    @endif
                                </td>
                                <td>{{ date('l, j F Y', strtotime($izin->tanggal_izin)) }} - {{ date('l, j F Y', strtotime($izin->sampai_tanggal)) }}</td>
                                <td>{{ $izin->keterangan }}</td>
                                <td>
                                    <a href="{{ route('izin.photo', ['id' => $izin->id]) }}" target="_blank" class="btn-transition btn btn-outline-primary">
                                        <i class="pe-7s-info"></i>
                                        <strong>
                                            Lihat Foto
                                        </strong>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
$(document).ready(function() {

    var yesterday = new Date((new Date()).valueOf()-1000*60*60*24);
    $('.datepicker').pickadate({
        format: 'd mmmm yyyy',
        labelMonthNext: 'Ke bulan selanjutnya',
        labelMonthPrev: 'Ke bulan sebelumnya',
        labelMonthSelect: 'Pilih bulan di list turunan',
        labelYearSelect: 'Pilih tahun di list turunan',
        selectMonths: true,
        selectYears: 100,
        disable: [
            { from: [0,0,0], to: yesterday }
        ]
    });

    @if (!empty(session()->get('message')))
        @if (session()->get('message') == "CREATE_SUCCESS")
        Swal.fire(
            'Laporan Izin Tersimpan!',
            'Laporan Izin telah berhasil tersimpan di database!',
            'success'
        );
        @endif
    @elseif (!empty($errors) && count($errors) != 0)
    Swal.fire(
        'Data Invalid',
        'Beberapa data yang di masukan tidak valid, mohon cek kembali!',
        'error'
    );
    @endif
});
</script>
@endsection
