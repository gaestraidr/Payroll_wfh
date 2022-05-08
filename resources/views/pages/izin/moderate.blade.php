@extends('layout.master')
@section('title', 'Data Izin Pegawai')
@section('description', 'Manage Data Izin Pegawai')
@section('icon', 'pe-7s-note2')

@section('page-content')
<div class="row justify-content-center mt-5">
    <div class="col-md-12 col-lg-8 container-centered">
        <div class="w-100 mb-3 card">
            <div class="card-header-tab card-header-tab-animation card-header">
                <div id="moderate-izin-title" class="card-header-title">
                    Detail Izin
                </div>
            </div>
            <div class="card-body">
                <div id="moderate-container" style="display: none;">
                    <div class="row justify-content-center">
                        <div class="text-center">
                            <h4 class="font-weight-bold text-primary">Foto Izin</h4>
                            <div class="dropdown-divider mb-3"></div>
                            <picture class="pull-left container-centered">
                                <img id="moderate-izin-photo" class="rounded img-fluid ml-3 mr-2" src="#" style="max-height: 260px;" alt="Foto Izin">
                            </picture>
                        </div>
                        <div class="col-sm-12 col-md-5 m-5">
                            <h4 class="font-weight-bold text-primary">Informasi Izin</h4>
                            <hr class="sidebar-divider">
                            <div class="position-relative row form-group">
                                <label class="col-sm-4 col-form-label font-weight-bold">Dibuat Tanggal</label>
                                <label id="moderate-izin-created-at" class="col-form-label">-</label>
                            </div>
                            <div class="position-relative row form-group">
                                <label class="col-sm-4 col-form-label font-weight-bold">Keterangan</label>
                                <label id="moderate-izin-keterangan" class="col-form-label">-</label>
                            </div>
                            <div class="position-relative row form-group">
                                <label class="col-sm-4 col-form-label font-weight-bold">Dari Tanggal</label>
                                <label id="moderate-izin-tanggal-izin" class="col-form-label">-</label>
                            </div>
                            <div class="position-relative row form-group">
                                <label class="col-sm-4 col-form-label font-weight-bold">Sampai Tanggal</label>
                                <label id="moderate-izin-sampai-tanggal" class="col-form-label">-</label>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider mb-3"></div>
                    <div id="moderate-allowed-container" class="row justify-content-center">
                        <button type="button" data-id="1" class="moderate-approve-button col-md-2 btn-transition btn btn-outline-success mr-5">
                            <i class="pe-7s-check"></i>
                            <strong>
                                Setujui
                            </strong>
                        </button>
                        <button type="button" data-id="2" class="moderate-approve-button col-md-2 btn-transition btn btn-outline-danger">
                            <i class="pe-7s-close-circle"></i>
                            <strong>
                                Tolak
                            </strong>
                        </button>
                    </div>
                    <div id="moderate-forbidden-container" class="row justify-content-center">
                        <button type="button" data-id="1" class="moderate-forbidden-button col-md-4 btn-transition btn btn-outline-secondary">
                            <i class="pe-7s-info"></i>
                            <strong>
                                Approval belum di-perbolehkan
                            </strong>
                        </button>
                    </div>
                </div>
                <div id="intro-container" class="text-center">
                    <picture class="pull-left">
                        <img class="img-fluid" src="{{ asset('assets/images/webart/webart-absensi.png')}}" style="max-height: 300px;" alt="Foto Circle 1">
                    </picture>
                    <p>Pilih salah satu data izin yang ada di bawah ini untuk melakukan moderasi.</p>
                </div>
                <div id="loading-container" class="text-center w-100" style="display: none;">
                    <picture>
                        <img class="img-fluid ml-3 mr-2" src="{{ asset('assets/images/animated/loading-animated2.gif')}}" alt="Loading Animation">
                    </picture>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-12 col-xl-12 ml-3">
    <div class="mb-3 card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <i class="header-icon pe-7s-note2 icon-gradient bg-love-kiss"></i>
                Laporan Izin Pegawai
            </div>
        </div>
        <div class="card-body">
            <table class="table w-100">
                <thead>
                    <th>Info Pegawai</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @if (count($data_izin) == 0)
                    <tr>
                        <td class="bg-light text-secondary text-center" colspan="4">Belum ada laporan izin baru.</td>
                    </tr>
                    @else
                        @foreach ($data_izin as $izin)
                            <tr>
                                <td>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="widget-content-left">
                                                    <img class="rounded-circle" src="{{ asset('assets/images/person.png') }}" alt="" width="40">
                                                </div>
                                            </div>
                                            <div class="widget-content-left flex2">
                                                <div class="widget-heading">{{ $izin->pegawai->name }} (<strong>{{ $izin->pegawai->email }}</strong>)</div>
                                                <div class="widget-subheading opacity-7">{{ $izin->pegawai->jabatan->nama_jabatan }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ date('l, j F Y', strtotime($izin->tanggal_izin)) }} - {{ date('l, j F Y', strtotime($izin->sampai_tanggal)) }}</td>
                                <td>{{ $izin->keterangan }}</td>
                                <td>
                                    <button type="button" data-id="{{ $izin->id }}" class="moderate-izin-button btn-transition btn btn-outline-warning">
                                        <i class="pe-7s-pen"></i>
                                        <strong>
                                            Moderasi Izin Ini
                                        </strong>
                                    </button>
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
    var intro_container = $('#intro-container');
    var loading_container = $('#loading-container');
    var moderate_container = $('#moderate-container');

    var allowed_container = $('#moderate-allowed-container');
    var forbidden_container = $('#moderate-forbidden-container');

    var izin_id = 0;

    $('.moderate-izin-button').click(function() {
        if (intro_container.is(":hidden"))
            moderate_container.toggle();

        intro_container.hide();
        loading_container.toggle();

        izin_id = $(this).attr('data-id');

        $.ajax({
            method: 'GET',
            url: '{{ route('izin.moderate') }}/' + izin_id,
            data: $('meta[name="csrf-token"]').attr('content')
        }).done(function(data) {
            var data_izin = data.data;

            $('#moderate-izin-title').html("Data Izin - " + data_izin.pegawai.name + " [Izin No. " + ('000' + data_izin.id).slice(-4) + "]");

            $('#moderate-izin-created-at').html(moment(data_izin.created_at).format('dddd, D MMMM YYYY'))
            $('#moderate-izin-keterangan').html(data_izin.keterangan);
            $('#moderate-izin-tanggal-izin').html(moment(data_izin.tanggal_izin).format('dddd, D MMMM YYYY'));
            $('#moderate-izin-sampai-tanggal').html(moment(data_izin.sampai_tanggal).format('dddd, D MMMM YYYY'));
            $('#moderate-izin-photo').attr('src', "{{ route('izin.photo', ['id' => ' ']) }}" + izin_id);

            allowed_container.toggle(data.approval_allowed);
            forbidden_container.toggle(!data.approval_allowed);

            loading_container.toggle();
            moderate_container.toggle();
        });
    });

    $(".moderate-forbidden-button").click(function() {
        Swal.fire(
          'Belum bisa memberi Approval',
          'Data Izin ini belum boleh di beri approval sebelum melewati tanggal 5 pada bulan selanjutnya.',
          'info'
        );
    });

    $(".moderate-approve-button").click(function() {
        var approval_id = $(this).attr('data-id');

        Swal.fire({
          title: (approval_id == 1 ? "Setujui" : "Tolak") +" Data Izin Ini?",
          icon: 'info',
          html: "Setelah moderasi approval di berikan, <strong>Data Izin</strong> ini akan terubah statusnya dan tidak bisa dikembalikan lagi!</strong>",
          showDenyButton: true,
          confirmButtonText: 'Lanjut',
          denyButtonText: 'Batalkan'
      }).then(function(result) {
          if (result.isConfirmed) {
              Swal.showLoading();
              $.ajax({
                  method: 'PUT',
                  url: "{{ route('izin.moderate') }}/" + izin_id + "/" + approval_id,
                  data: "_token=" + $('meta[name="csrf-token"]').attr('content'),
                  success: function(data) {
                      setTimeout(function(){ window.location.href='{{ route('izin.moderate') }}'; }, 1000);
                      Swal.fire(
                        'Approval telah berhasil di simpan!',
                        'Data Izin telah berhasil di ubah statusnya!',
                        'success'
                      );
                  },
                  error: function(xhr) {
                      var data = JSON.parse(xhr.responseText);
                      if (data.status == "ERR_FORBIDDEN") {
                          Swal.fire(
                            'Pemberian Approval Dilarang',
                            'Data Izin ini belum boleh di beri approval!',
                            'error'
                          );
                      }
                      else {
                          Swal.fire(
                            'Terjadi kesalahan! [Interval Server Error 500]',
                            'Terjadi kesalahan pada saat memasukan approval, mohon laporkan ke developer!',
                            'error'
                          );
                      }
                  }
              })
          }
        });
    });
});
</script>
@endsection
