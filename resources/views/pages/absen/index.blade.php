@extends('layout.master')
@section('title', 'Absen Harian')
@section('description', 'Lakukan Absen Harian')
@section('icon', 'pe-7s-stopwatch')

@section('page-content')
<div class="row justify-content-center mt-5">
    <picture class="pull-left">
        <img class="img-fluid" src="{{ asset('assets/images/webart/webart-absensi.png')}}" style="max-height: 500px;" alt="Foto Circle 1">
    </picture>
    <div class="col-md-12 col-lg-6 col-xl-5 ml-3 container-centered">
        <div class="w-100 mb-3 card">
            <div class="card-header-tab card-header-tab-animation card-header">
                <div class="card-header-title">
                    <i class="header-icon pe-7s-stopwatch icon-gradient bg-love-kiss"></i>
                    Absen Harian
                </div>
            </div>
            <div class="card-body">
                <p>Disini anda bisa melakukan absensi harian, <br/>dengan menekan tombol dibawah absensi akan langsung ter-rekor di database.</p>
                @if ($check_absen->status == 'ERR_FORBIDDEN')
                <p class="text-danger">Absensi tidak di ijinkan untuk jalur Work-From-Home!</p>
                <a href="javascript:void(0)" class="btn btn-secondary btn-icon-split mt-3">
                  <span class="icon text-white-50">
                  <i class="fas fa-info-circle"></i>
                  </span>
                  <span class="text">Absensi Tidak Diperbolehkan</span>
                </a>
                @else
                    @if ($check_absen->count == 0)
                    <button class="button-absen btn btn-info btn-icon-split mt-3">
                      <span class="icon text-white-50">
                      <i class="fas fa-highlighter"></i>
                      </span>
                      <span class="text">Lakukan Absen Masuk</span>
                    </button>
                    @elseif ($check_absen->count == 1)
                        @if ($check_absen->status == 'WARN_WAIT')
                        <p class="text-info">Absensi Pulang baru bisa di lakukan setelah pukul {{ date('g:i A', strtotime($absen_today[0]->created_at . '+8 hours')) }}</p>
                        <a href="javascript:void(0)" class="btn btn-secondary btn-icon-split mt-3">
                          <span class="icon text-white-50">
                          <i class="fas fa-info-circle"></i>
                          </span>
                          <span class="text">Tunggu {{ date('g:i A', strtotime($absen_today[0]->created_at . '+8 hours')) }}</span>
                        </a>
                        @else
                        <button class="button-absen btn btn-warning btn-icon-split mt-3">
                          <span class="icon text-white-50">
                          <i class="fas fa-highlighter"></i>
                          </span>
                          <span class="text">Lakukan Absen Pulang</span>
                        </button>
                        @endif
                    @else
                    <a href="javascript:void(0)" class="btn btn-secondary btn-icon-split mt-3">
                      <span class="icon text-white-50">
                      <i class="fas fa-info-circle"></i>
                      </span>
                      <span class="text">Sudah Absen</span>
                    </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-12 col-xl-12 ml-3">
    <div class="mb-3 card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <i class="header-icon pe-7s-clock icon-gradient bg-love-kiss"></i>
                Absen Hari Ini
            </div>
        </div>
        <div class="card-body">
            <table class="table w-100">
                <thead>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Absen</th>
                </thead>
                <tbody>
                    @if ($check_absen->count == 0)
                    <tr>
                        <td class="bg-light text-secondary text-center" colspan="4">Belum ada data Absensi hari ini.</td>
                    </tr>
                    @else
                        @foreach($absen_today as $absen)
                            <tr>
                                <td style="font-size: 40px;">
                                    <i class="metismenu-icon pe-7s-clock {{ $absen->keterangan == 1 ? 'text-success' : 'text-warning' }}"></i>
                                </td>
                                <td>{{ date('l, j F Y g:i A', strtotime($absen->created_at)) }}</td>
                                <td>{{ $absen->keterangan == 1 ? 'Absen Masuk' : 'Absen Pulang' }}</td>
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
    @if ($check_absen->status == 'ABSENSI_ALLOWED')
    $('.button-absen').on('click', function() {
        Swal.showLoading();
        $.ajax({
            method: 'POST',
            url: '{{ route('absensi.store') }}',
            data: "_token=" + $('meta[name="csrf-token"]').attr('content')
        }).done(function(data) {
            if (data.status == "SUCCESS") {
                setTimeout(function(){ window.location.href='{{ route('absensi.detail') }}'; }, 1500);
                Swal.fire(
                  'Absensi berhasil!',
                  'Absensi berhasil di terima di server! Anda akan di arahkan ke halaman data.',
                  'success'
                );
            }
            else Swal.fire(
              'Absensi gagal',
              'Terjadi kesalahan saat melakukan absensi. CODE: ' + data.status,
              'error'
            );
        });
    });
    @endif
});
</script>
@endsection
