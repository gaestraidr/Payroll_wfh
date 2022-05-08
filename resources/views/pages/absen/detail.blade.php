@extends('layout.master')
@section('title', 'Data Absensi')
@section('description', 'Lihat Data Absensi')
@section('icon', 'pe-7s-clock')

@section('page-content')
<div class="row justify-content-center mt-5">
    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                @if (auth()->user()->role == 2)
                <div class="row justify-content-between m-1 w-100">
                    <h4 id="pegawai-title" class="card-title pt-2">Profile Pegawai - {{ $data_pegawai->name }}</h4>
                    <div class="input-group col-md-5" >
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-id-card"></i>
                            </div>
                        </div>
                        <select id="pegawai-list" class="form-control">
                            @foreach ($data_pegawai_list as $pegawai)
                            <option value="{{ $pegawai->id }}" {{ $pegawai->id == $data_pegawai->id ? 'selected' : '' }}>{{ $pegawai->name }} - {{ $pegawai->jabatan->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @else
                <h4 class="card-title">Profile Pegawai</h4>
                @endif
            </div>
            <div class="card-body">
                <div id="profile-box" class="row {{ auth()->user()->role == 2 ? 'justify-content-center' : '' }}">
                    <picture class="pull-left">
                        <img class="img-fluid ml-3 mr-2" src="{{ asset('assets/images/person.png')}}" style="max-height: 260px;" alt="Foto Circle 1">
                    </picture>
                    <div class="col-sm-12 col-md-5 m-5">
                        <h4 id="pegawai-name-box" class="font-weight-bold text-primary">{{ $data_pegawai->name }}</h5>
                        <hr class="sidebar-divider">
                        <div class="position-relative row form-group">
                            <label class="col-sm-4 col-form-label font-weight-bold">No. Induk Pegawai</label>
                            <label id="pegawai-nomor-induk-box" class="col-form-label">{{ $data_pegawai->nomor_induk }}</label>
                        </div>
                        <div class="position-relative row form-group">
                            <label class="col-sm-4 col-form-label font-weight-bold">Jabatan</label>
                            <label id="pegawai-jabatan-box" class="col-form-label">{{ $data_pegawai->jabatan->nama_jabatan }}</label>
                        </div>
                        <div class="position-relative row form-group">
                            <label class="col-sm-4 col-form-label font-weight-bold">E-mail</label>
                            <label id="pegawai-contact-box" class="col-form-label">{{ $data_pegawai->email }}</label>
                        </div>
                    </div>
                </div>
                <div id="loading-container-profile" class="text-center w-100" style="display: none;">
                    <picture>
                        <img class="img-fluid ml-3 mr-2" src="{{ asset('assets/images/animated/loading-animated2.gif')}}" alt="Loading Animation">
                    </picture>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between m-1 w-100">
                    <h4 id="absensi-title" class="card-title pt-2">Absensi Pegawai - {{ date('F') }}</h4>
                    <div class="input-group col-md-5 date" data-provide="datepicker">
                        <div class="input-group-prepend datepicker-trigger">
                            <div class="input-group-text">
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                        </div>
                        <select id="date-box" class="form-control">
                            <option value="1" {{ intval(date('n')) == 1 ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ intval(date('n')) == 2 ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ intval(date('n')) == 3 ? 'selected' : '' }}>Maret</option>
                            <option value="4" {{ intval(date('n')) == 4 ? 'selected' : '' }}>April</option>
                            <option value="5" {{ intval(date('n')) == 5 ? 'selected' : '' }}>May</option>
                            <option value="6" {{ intval(date('n')) == 6 ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ intval(date('n')) == 7 ? 'selected' : '' }}>Juli</option>
                            <option value="8" {{ intval(date('n')) == 8 ? 'selected' : '' }}>Agustus</option>
                            <option value="9" {{ intval(date('n')) == 9 ? 'selected' : '' }}>September</option>
                            <option value="10" {{ intval(date('n')) == 10 ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ intval(date('n')) == 11 ? 'selected' : '' }}>November</option>
                            <option value="12" {{ intval(date('n')) == 12 ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="table w-100">
                    <thead>
                        <th style="max-width: 50px">Status</th>
                        <th style="max-width: 60px">Tanggal</th>
                        <th>Absen</th>
                        <th>Info</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="row widget">
                    <a id="cetak-rekapan-button" href="javascript:void(0)" class="btn btn-primary btn-icon-split mt-2">
                      <span class="icon text-white-50">
                      <i class="fas fa-file"></i>
                      </span>
                      <span class="text">Cetak Rekapan Absensi</span>
                    </a>
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
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    // Absensi Monthly
    var holiday_data = [];
    var date = new Date();
    @if (auth()->user()->role == 2)
    var user_id = {{ $data_pegawai->id }};
    @endif

    function getHolidayDate(date) {
        return holiday_data.holidays.find(record => moment(record.date).format('D MMMM') == moment(date).format('D MMMM'));
    }

    $.ajax({
        method: 'GET',
        url: '{{ route('absensi.holiday') }}',
        data: "_token=" + $('meta[name="csrf-token"]').attr('content')
    }).done(function(data) {
        holiday_data = data;

        // First Init
        setTimeout(function() {
            date = new Date((date.getYear() + 1900), date.getMonth() + 1, 0);
            fetchDataWithMonth(date.getMonth() + 1);
        }, 200);
    });


    $('#date-box').change(function() {
        date = new Date((date.getYear() + 1900), $(this).val(), 0);

        $("#absensi-title").html("Absensi Pegawai - " + date.toLocaleString('default', { month: 'long' }));
        fetchDataWithMonth($(this).val());
    });

    function fetchDataWithMonth(month) {
        if (isSearching)
            toggleSearchBox();

        toggleSearchBox();
        $.ajax({
            method: 'GET',
            @if (auth()->user()->role == 2)
            url: '{{ route('absensi.monthly', ['month' => ' ']) }}' + month + '/' + user_id,
            @else
            url: '{{ route('absensi.monthly', ['month' => ' ']) }}' + month,
            @endif
            data: "_token=" + $('meta[name="csrf-token"]').attr('content')
        }).done(function(json) {
            let data = json.data;
            let table_body = "";

            for (let i = 1; i <= date.getDate(); i++) {
                let absen_masuk = data.find(record => parseInt(moment(record.created_at).format("D")) === i && record.keterangan == 1);
                let absen_pulang = data.find(record => parseInt(moment(record.created_at).format("D")) === i && record.keterangan == 2);
                let date_data = (date.getYear() + 1900) + "-" + ('0' + (date.getMonth() + 1)).slice(-2) + "-" + ('0' + i).slice(-2);

                table_body += insertAbsenHeaderRow(date_data);
                if (getHolidayDate(date_data) && !absen_masuk && !absen_pulang) {
                    table_body += insertAbsenHoliday(date_data);
                }
                else {
                    table_body += insertAbsenRow(absen_masuk, date_data);
                    table_body += insertAbsenRow(absen_pulang, date_data);
                }
            }

            $("#table-data tbody").html(table_body)
            @if (auth()->user()->role == 2)
            $("#cetak-rekapan-button").attr('href', "{{ route('absensi.detail') }}/print/" + (date.getMonth() + 1) + "/" + user_id );
            @else
            $("#cetak-rekapan-button").attr('href', "{{ route('absensi.detail') }}/print/"  + (date.getMonth() + 1));
            @endif
            toggleSearchBox();
        });
    }

    function insertAbsenHeaderRow(date_data) {
        return "<tr><td class=\"bg-info text-white text-center font-weight-bold\" style=\"font-size: 20px;\" colspan=\"4\">" + moment(date_data).format('dddd, D MMMM YYYY') + "</td></tr>";
    }

    function insertAbsenHoliday(date) {
        return "<tr><td class=\"text-white text-center font-weight-bold\" style=\"background: #a8a1a1; font-size: 15px;\" colspan=\"4\">Libur " + getHolidayDate(date).name + "</td></tr>";
    }

    function insertAbsenRow(data, date_data) {
        let row = "";

        if (data) {
            row += "<tr>";
            row += "<td style=\"font-size: 40px;\"><i class=\"metismenu-icon pe-7s-clock " + (data.keterangan == 1 ? "text-success" : "text-warning") + "\"></i></td>";
            row += "<td>" + moment(data.created_at).format('dddd, D MMMM YYYY h:mm A') + "</td>";
            row += "<td>" + (data.keterangan == 1 ? "Absen Masuk" : "Absen Pulang") + "</td>";
            row += "<td>" + data.status > 2 ? "Lembur " + getHolidayDate(data.created_at).name : "-" + "</td>";
            row += "</tr>";
        }
        else if (getHolidayDate(date_data)) {
            row += insertAbsenHoliday(date_data);
        }
        else {
            row += "<tr" + (moment(date_data).isBefore(moment()) ? " style=\"background: #ae3d3d;\"" : "" ) + ">";
            row += "<td style=\"font-size: 40px;\"><i class=\"metismenu-icon pe-7s-clock" + (moment(date_data).isBefore(moment()) ? " text-white" : "" ) + "\"></i></td>";
            row += "<td class=\"font-weight-bold" + (moment(date_data).isBefore(moment()) ? " text-white" : "" ) + "\"> - </td>";
            row += "<td class=\"font-weight-bold" + (moment(date_data).isBefore(moment()) ? " text-white" : "" ) + "\"> - </td>";
            row += "<td class=\"font-weight-bold" + (moment(date_data).isBefore(moment()) ? " text-white" : "" ) + "\"> - </td>";
            row += "</tr>";
        }

        return row;
    }

    var isSearching = false;
    function toggleSearchBox() {
        $("#table-data").toggle();
        $("#loading-container").toggle();
        $("#cetak-rekapan-button").toggle();
        isSearching = !isSearching;
        $('.datepicker').attr('disabled', isSearching);
    }

    @if (auth()->user()->role == 2)
    function toggleSearchBoxProfile() {
        toggleSearchBox();
        $("#pegawai-list").attr('disabled', isSearching);
        $("#profile-box").toggle();
        $("#loading-container-profile").toggle();
    }

    $("#pegawai-list").change(function() {
        fetchDataUser($(this).val());
    });

    function fetchDataUser(id) {
        if (isSearching)
            toggleSearchBoxProfile();

        toggleSearchBoxProfile();
        $.ajax({
            method: 'GET',
            url: '{{ route('pegawai.detail', ['id' => ' ']) }}' + id,
            data: "_token=" + $('meta[name="csrf-token"]').attr('content')
        }).done(function(json) {
            let data = json.data;

            $("#pegawai-name-box").html(data.name);
            $("#pegawai-nomor-induk-box").html(data.nomor_induk);
            $("#pegawai-jabatan-box").html(data.jabatan.nama_jabatan);
            $("#pegawai-contact-box").html(data.email);

            toggleSearchBoxProfile();
            $("#pegawai-title").html("Profile Pegawai - " + data.name)
            user_id = data.id;
            fetchDataWithMonth(date.getMonth() + 1);
        });
    }
    @endif
});
</script>
@endsection
