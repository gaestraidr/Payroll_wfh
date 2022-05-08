@extends('layout.master')
@section('title', 'Data Jabatan')
@section('description', 'Manage Data Jabatan')
@section('icon', 'pe-7s-id')

@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-5 mb-3 ">
            <a href="{{ route('jabatan.create') }}" class="col-md-6 btn-transition btn btn-outline-primary">
                <i class="pe-7s-plus"></i>
                <strong>
                    Tambah Jabatan
                </strong>
            </a>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-header">
                Table Data Jabatan
                <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Jabatan</th>
                            <th class="text-center">Info</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php ( $i = 0 )
                        @foreach ($data_jabatan as $jabatan)
                        <tr>
                            <td class="text-center">{{ ++$i }}</td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left">
                                                <img class="rounded-circle" src="{{ asset('assets/images/person.png') }}" alt="" width="40">
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">{{ $jabatan->nama_jabatan }}</div>
                                            <div class="widget-subheading opacity-7">Gaji Pokok Rp. {{ number_format($jabatan->gaji_pokok) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                Mode Absensi: {{ $jabatan->remote_absen }}
                                @if ($jabatan->remote_absen == 2)
                                    (Boleh Work-From-Home)
                                @elseif ($jabatan->remote_absen == 3)
                                    (Work-From-Home Hanya Di Awal Bulan)
                                @else
                                    (Hanya Di-Kantor)
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('jabatan.edit', ['id' => $jabatan->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit pr-1"></i>Ubah</a>
                                @if ($jabatan->id != auth()->user()->id)
                                <button class="btn btn-danger btn-sm delete-jabatan" data-id="{{ $jabatan->id }}"><i class="fa fa-trash"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    $(".delete-jabatan").on('click', function() {
        var id = $(this).attr('data-id');

        Swal.fire({
          title: 'Hapus Jabatan Ini?',
          icon: 'warning',
          html: "Apa kamu yakin untuk menghapus <strong>Jabatan</strong> ini?<br/><strong>Data Jabatan yang telah di hapus, tidak bisa dikembalikan lagi</strong>",
          showDenyButton: true,
          confirmButtonText: 'Hapus',
          denyButtonText: 'Batalkan'
        }).then(function(result) {
          if (result.isConfirmed) {
              Swal.showLoading();
              $.ajax({
                  method: 'DELETE',
                  url: "{{ route('jabatan') }}/delete/" + id,
                  data: "_token=" + $('meta[name="csrf-token"]').attr('content')
              }).done(function(data) {
                  setTimeout(function(){ window.location.href='{{ route('jabatan') }}'; }, 1000);
                  Swal.fire(
                    'Jabatan telah di hapus!',
                    'Data Jabatan telah berhasil di ubah!',
                    'success'
                  );
              });
          }
        });
    });

    @if (!empty(session()->get('message')))
        @if (session()->get('message') == "CREATE_SUCCESS")
        Swal.fire(
          'Data telah di masukan!',
          'Data Jabatan telah berhasil di dimasukan!',
          'success'
        );
        @elseif (session()->get('message') == "UPDATE_SUCCESS")
        Swal.fire(
          'Data telah di ubah!',
          'Data Jabatan telah berhasil di update!',
          'success'
        );
        @endif
    @endif
});
</script>
@endsection
