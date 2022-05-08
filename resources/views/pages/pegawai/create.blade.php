@extends('layout.master')
@section('title', 'Tambah Data Pegawai')
@section('description', 'Halaman Penambahan Pegawai')
@section('icon', 'pe-7s-id')

@section('page-content')
<div class="row justify-content-center">
    <div class="col-sm-12 col-md-8">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Tambah Data Pegawai</h5>
                <div class="dropdown-divider mb-3"></div>
                <form id="form-create-pegawai" action="{{ route('pegawai.store') }}" method="POST">
                    @csrf
                    <div class="position-relative row form-group"><label for="name" class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-5"><input name="name" id="name" placeholder="Nama Pegawai" type="name" class="form-control" required></div>
                    </div>
                    @error('name')
                    <div class="position-relative row form-group"><label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="email" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-5"><input name="email" id="email" placeholder="E-mail" type="email" class="form-control" required></div>
                    </div>
                    @error('email')
                    <div class="position-relative row form-group"><label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-5"><input name="password" id="password" placeholder="********" type="password" class="form-control" required></div>
                    </div>
                    @error('password')
                    <div class="position-relative row form-group"><label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="no_rek" class="col-sm-2 col-form-label">No. Rekening</label>
                        <div class="col-sm-5"><input name="no_rek" id="no_rek" data-type="only-number" placeholder="Nomor Rekening" type="text" class="form-control" required></div>
                    </div>
                    @error('no_rek')
                    <div class="position-relative row form-group"><label for="no_rek" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="jabatan" class="col-sm-2 col-form-label">Jabatan Pegawai</label>
                        <div class="col-sm-4">
                            <select name="jabatan_id" id="jabatan_id" type="jabatan_id" class="form-control" required>
                                @foreach($data_jabatan as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('jabatan_id')
                    <div class="position-relative row form-group"><label for="jabatan_id" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="position-relative row form-group"><label for="role" class="col-sm-2 col-form-label">Akses Web</label>
                        <div class="col-sm-3">
                            <select name="role" id="role" type="role" class="form-control" required>
                                <option value="1">
                                    Pegawai
                                </option>
                                <option value="2">
                                    Manager
                                </option>
                            </select>
                        </div>
                    </div>
                    @error('role')
                    <div class="position-relative row form-group"><label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5"><p class="text-danger font-weight-bold">{{ $message }}</p></div>
                    </div>
                    @enderror
                    <div class="dropdown-divider mb-3"></div>
                    <div class="position-relative row form-check">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="col-md-6 btn-transition btn btn-outline-primary">
                                <i class="pe-7s-plus"></i>
                                <strong>
                                    Tambah Pegawai
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
<script type="text/javascript" src="{{ asset('assets/js/comp/number-formatter.js') }}"></script>
<script type="text/javascript">
$(document).ready(function (){

});
</script>
@endsection
