@extends('layout.master')
@section('title', 'Data Pegawai')
@section('description', 'Manage Data Pegawai')
@section('icon', 'pe-7s-id')

@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-5 mb-3 ">
            <a href="{{ route('pegawai.create') }}" class="col-md-6 btn-transition btn btn-outline-primary">
                <i class="pe-7s-plus"></i>
                <strong>
                    Tambah Pegawai
                </strong>
            </a>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-header">
                Table Data Pegawai
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
                            <th>Pegawai</th>
                            <th class="text-center">Info</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php ( $i = 0 )
                        @foreach ($data_pegawai as $pegawai)
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
                                            <div class="widget-heading">{{ $pegawai->name }} (<strong>{{ $pegawai->email }}</strong>)</div>
                                            <div class="widget-subheading opacity-7">{{ $pegawai->jabatan->nama_jabatan }}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center{{ $pegawai->jumlah_cuti < 0 ? ' text-danger font-weight-bold' : '' }}">
                                Jumlah Cuti: {{ $pegawai->jumlah_cuti }} {{ $pegawai->jumlah_cuti < 0 ? '(Pegawai Bermasalah)' : '' }}</br>
                                No. Induk Pegawai: {{ $pegawai->nomor_induk }}
                            </td>
                            <td class="text-center">{{ $pegawai->role == 1 ? 'Pegawai' : 'Manager' }}</td>
                            <td class="text-center">
                                <a href="{{ route('absensi.detail', ['id' => $pegawai->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-info-circle pr-1"></i>Lihat</a>
                                <a href="{{ route('pegawai.edit', ['id' => $pegawai->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit pr-1"></i>Ubah</a>
                                @if ($pegawai->id != auth()->user()->id)
                                <button class="btn btn-danger btn-sm delete-pegawai" data-id="{{ $pegawai->id }}"><i class="fa fa-trash"></i></button>
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
    $(".delete-pegawai").on('click', function() {
        var id = $(this).attr('data-id');

        Swal.fire({
          title: 'Hapus Pegawai Ini?',
          icon: 'warning',
          html: "Apa kamu yakin untuk menghapus <strong>Pegawai</strong> ini?<br/><strong>Data Pegawai yang telah di hapus, tidak bisa dikembalikan lagi</strong>",
          showDenyButton: true,
          confirmButtonText: 'Hapus',
          denyButtonText: 'Batalkan'
        }).then(function(result) {
          if (result.isConfirmed) {
              Swal.showLoading();
              $.ajax({
                  method: 'DELETE',
                  url: "{{ route('pegawai') }}/delete/" + id,
                  data: "_token=" + $('meta[name="csrf-token"]').attr('content')
              }).done(function(data) {
                  setTimeout(function(){ window.location.href='{{ route('pegawai') }}'; }, 1000);
                  Swal.fire(
                    'Pegawai telah di hapus!',
                    'Data Pegawai telah berhasil di ubah!',
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
          'Data Pegawai telah berhasil di dimasukan!',
          'success'
        );
        @elseif (session()->get('message') == "UPDATE_SUCCESS")
        Swal.fire(
          'Data telah di ubah!',
          'Data Pegawai telah berhasil di update!',
          'success'
        );
        @endif
    @endif
});
</script>
@endsection
