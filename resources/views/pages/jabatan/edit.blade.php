@extends('layout.master')
@section('title', 'Ubah Data Jabatan')
@section('description', 'Halaman Pengubahan Jabatan')
@section('icon', 'pe-7s-id')

@section('page-content')
<div class="row justify-content-center">
    <div class="col-sm-12 col-md-8">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Ubah Data Jabatan</h5>
                <div class="dropdown-divider mb-3"></div>
                <form id="form-update-jabatan" action="{{ route('jabatan.update', ['id' => $data_jabatan->id]) }}" method="POST">
                    {{ method_field('PUT') }}
                    @csrf
                    <div class="position-relative row form-group"><label for="nama_jabatan" class="col-sm-2 col-form-label">Nama Jabatan</label>
                        <div class="col-sm-5"><input name="nama_jabatan" id="nama_jabatan" placeholder="Nama Jabatan" type="nama_jabatan" class="form-control" value="{{ $data_jabatan->nama_jabatan }}" required></div>
                    </div>
                    @error('nama_jabatan')
                    <div class="position-relative row form-group"><label for="nama_jabatan" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="gaji_pokok" class="col-sm-2 col-form-label">Gaji Pokok</label>
                        <div class="col-sm-5">
                            <input name="gaji_pokok" id="gaji_pokok" data-type="currency-number" placeholder="0" type="gaji_pokok" class="form-control" value="{{ $data_jabatan->gaji_pokok }}" required>
                        </div>
                    </div>
                    @error('gaji_pokok')
                    <div class="position-relative row form-group"><label for="gaji_pokok" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="remote_absen" class="col-sm-2 col-form-label">Mode Absensi</label>
                        <div class="col-sm-5">
                            <select name="remote_absen" id="remote_absen" type="remote_absen" class="form-control" required>
                                <option value="1" {{ $data_jabatan->remote_absen == 1 ? 'selected' : '' }}>
                                    Hanya Di-Kantor
                                </option>
                                <option value="2" {{ $data_jabatan->remote_absen == 2 ? 'selected' : '' }}>
                                    Boleh Work-From-Home
                                </option>
                                <option value="3" {{ $data_jabatan->remote_absen == 3 ? 'selected' : '' }}>
                                    Work-From-Home Hanya Di Awal Bulan
                                </option>
                            </select>
                        </div>
                    </div>
                    @error('remote_absen')
                    <div class="position-relative row form-group"><label for="remote_absen" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="dropdown-divider mb-3"></div>
                    <div class="position-relative row form-check">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="col-md-6 btn-transition btn btn-outline-primary">
                                <i class="pe-7s-plus"></i>
                                <strong>
                                    Ubah Jabatan
                                </strong>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script type="text/javascript" src="{{ asset('assets/js/comp/currency.js') }}"></script>
<script type="text/javascript">
$(document).ready(function (){
    formatCurrency($("input[data-type='currency-number']"), "blur");

    $('#form-update-jabatan').submit(function(e) {
        var gaji = $('#gaji_pokok').val();
        $('#gaji_pokok').val(formatCurrencyToNumber(gaji));
    })
});
</script>
@endsection
