@extends('layout.master')
@section('title', 'Data Gaji Pegawai')
@section('description', 'Lihat Data Gaji Pegawai')
@section('icon', 'pe-7s-news-paper')

@section('page-content')
<div class="row">
    <ul class="tabs-animated-shadow tabs-animated nav">
      <li class="nav-item">
          <a href="#gaji-invoice" class="nav-link show active" data-toggle="tab" aria-selected="true">
              <span>Cetak Satu Gaji</span>
          </a>
      </li>
      @if (auth()->user()->role == 2)
      <li class="nav-item">
          <a href="#gaji-bulk-invoice" class="nav-link show" data-toggle="tab" aria-selected="false">
              <span>Cetak Semua Gaji</span>
          </a>
      </li>
      @endif
    </ul>
</div>

<div class="tab-content mt-5">
    <div id="gaji-invoice" class="tab-pane w-100 row justify-content-center show active">
        <div class="mx-auto col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between m-1 w-100">
                        <h4 id="pegawai-title" class="card-title pt-2">Profile Pegawai - {{ $data_pegawai[0]->name }}</h4>
                        @if (auth()->user()->role == 2)
                        <div class="input-group col-md-5" >
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-id-card"></i>
                                </div>
                            </div>
                            <select id="pegawai-list" class="form-control">
                                @foreach ($data_pegawai as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->name }} - {{ $pegawai->jabatan->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div id="profile-box" class="row {{ auth()->user()->role == 2 ? 'justify-content-center' : '' }}">
                        <picture class="pull-left">
                            <img class="img-fluid ml-3 mr-2" src="{{ asset('assets/images/person.png')}}" style="max-height: 260px;" alt="Foto Circle 1">
                        </picture>
                        <div class="col-sm-12 col-md-5 m-5">
                            <h4 id="pegawai-name-box" class="font-weight-bold text-primary">{{ $data_pegawai[0]->name }}</h5>
                            <hr class="sidebar-divider">
                            <div class="position-relative row form-group">
                                <label class="col-sm-4 col-form-label font-weight-bold">No. Induk Pegawai</label>
                                <label id="pegawai-nomor-induk-box" class="col-form-label">{{ $data_pegawai[0]->nomor_induk }}</label>
                            </div>
                            <div class="position-relative row form-group">
                                <label class="col-sm-4 col-form-label font-weight-bold">Jabatan</label>
                                <label id="pegawai-jabatan-box" class="col-form-label">{{ $data_pegawai[0]->jabatan->nama_jabatan }}</label>
                            </div>
                            <div class="position-relative row form-group">
                                <label class="col-sm-4 col-form-label font-weight-bold">E-mail</label>
                                <label id="pegawai-contact-box" class="col-form-label">{{ $data_pegawai[0]->email }}</label>
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
        <div class="col-sm-12 col-md-12 mt-5">
            <div class="card">
                <div class="card-header no-print">
                    <div class="row justify-content-between m-1 w-100">
                        <h4 id="gaji-title" class="card-title pt-2">Gaji Pegawai - {{ date('F') }}</h4>
                        <div class="col-md-{{ auth()->user()-> role == 2 ? '5' : '3' }} row widget">
                            <div class="input-group col-md-{{ auth()->user()-> role == 2 ? '8' : '12' }} date" data-provide="datepicker">
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
                            @if (auth()->user()->role == 2)
                            <button id="cetak-gaji-button" type="button" class="btn btn-primary btn-icon-split">
                              <span class="icon text-white-50">
                              <i class="fas fa-file"></i>
                              </span>
                              <span class="text">Cetak Gaji Pegawai</span>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="gaji-container" class="invoice text-center">
                        <div style="min-width: 600px">
                            <header>
                                <div class="row">
                                    <div class="col mb-3">
                                        <a target="_blank" href="#">
                                            <picture class="pull-left">
                                                <img class="img-fluid ml-3 mr-2" src="{{ asset('assets/images/logo-inverse.png') }}" style="max-height: 100px;" alt="Foto Circle 1">
                                            </picture>
                                        </a>
                                    </div>
                                    <div class="col company-details">
                                        <h2 class="name">
                                            <a target="_blank" href="#">
                                            Warehouse DC
                                            </a>
                                        </h2>
                                        <div>(Alamat) Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras auctor at ligula et mollis. Cras molestie magna magna, non euismod dui ornare id.</div>
                                        <div>+62 251 7554422 </div>
                                        <div>info@company.com</div>
                                    </div>
                                </div>
                            </header>
                            <main>
                                <div class="row contacts">
                                    <div class="col detail-to">
                                        <div class="text-gray-light">CETAKAN GAJI:</div>
                                        <h2 id="pegawai" class="pegawai">{{ $data_pegawai[0]->name }}</h2>
                                        <div id="jabatan" class="jabatan">{{ $data_pegawai[0]->jabatan->nama_jabatan }}</div>
                                        <div id="email" class="email"><a href="mailto:{{ $data_pegawai[0]->email }}">{{ $data_pegawai[0]->email }}</a></div>
                                    </div>
                                    <div class="col detail-gaji">
                                        <h1 id="gaji-id" class="gaji-id">Struk No. ?</h1>
                                        <div id="date" class="date">Pada Bulan: ????/??</div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="table-responsive align-middle">
                                  <table id="cetak-table" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SR NO.</th>
                                            <th class="text-left">JENIS</th>
                                            <th class="text-center">NILAI</th>
                                            <th class="text-center">PAJAK</th>
                                            <th class="text-center">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2" class="text-success"><h5>Total Gaji Bersih</h5></td>
                                            <td id="unit" class="text-success">Rp 0.00</td>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </div>
                                <div class="thanks">Tercetak pada tanggal <strong>{{ date('d F Y') }}</strong> oleh <strong>{{ auth()->user()->name }}</strong></div>
                                <div class="notices">
                                    <div>-</div>
                                    <div class="notice"><strong>NB*</strong> Data cetakan ini adalah bukti dari riwayat data gaji <strong>Pegawai</strong> bersangkutan.</div>
                                </div>
                            </main>
                        </div>
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
    @if (auth()->user()->role == 2)
    <div id="gaji-bulk-invoice" class="tab-pane w-100 show">
        <div class="card">
            <div class="card-header no-print">
                <div class="row justify-content-between m-1 w-100">
                    <h4 id="gaji-title-bulk" class="card-title pt-2">Gaji Pegawai - {{ date('F') }}</h4>
                    <div class="col-md-8 row widget">
                        <div class="input-group col-md-6 date" data-provide="datepicker">
                            <div class="input-group-prepend datepicker-trigger">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar-alt"></i>
                                </div>
                            </div>
                            <select id="date-box-bulk" class="form-control">
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
                        <button id="cetak-gaji-button-bulk" type="button" class="btn btn-primary btn-icon-split mr-2">
                            <span class="icon text-white-50">
                            <i class="fas fa-file"></i>
                            </span>
                            <span class="text">Cetak Gaji Pegawai</span>
                        </button>
                        <a id="download-gaji-button-bulk" href="javascript:void(0)" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                            <i class="fas fa-download"></i>
                            </span>
                            <span class="text">Download Excel (.xlsx)</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="gaji-bulk-container" class="invoice text-center">
                    <div style="min-width: 600px">
                        <header>
                            <div class="row">
                                <div class="col mb-3">
                                    <a target="_blank" href="#">
                                        <picture class="pull-left">
                                            <img class="img-fluid ml-3 mr-2" src="{{ asset('assets/images/logo-inverse.png') }}" style="max-height: 100px;" alt="Foto Circle 1">
                                        </picture>
                                    </a>
                                </div>
                                <div class="col company-details">
                                    <h2 class="name">
                                        <a target="_blank" href="#">
                                        Warehouse DC
                                        </a>
                                    </h2>
                                    <div>(Alamat) Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras auctor at ligula et mollis. Cras molestie magna magna, non euismod dui ornare id.</div>
                                    <div>+62 251 7554422 </div>
                                    <div>info@company.com</div>
                                </div>
                            </div>
                        </header>
                        <main>
                            <div class="row contacts">
                                <div class="col detail-gaji">
                                    <h1 class="header">Struk Gaji Semua Karyawan</h1>
                                    <div id="date-bulk" class="date-bulk">Tanggal Gaji: ????/??/??</div>
                                </div>
                            </div>
                            <hr/>
                            <div class="table-responsive align-middle">
                            <table id="cetak-bulk-table" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No. </th>
                                        <th class="text-left">Pegawai</th>
                                        <th class="text-center">Gaji Pokok</th>
                                        <th class="text-center">Pajak</th>
                                        <th class="text-center">Lemburan</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            </div>
                            <div class="thanks">Tercetak pada tanggal <strong>{{ date('d F Y') }}</strong> oleh <strong>{{ auth()->user()->name }}</strong></div>
                            <div class="notices">
                                <div>-</div>
                                <div class="notice"><strong>NB*</strong> Data cetakan ini adalah bukti dari riwayat data gaji <strong>Pegawai</strong> bersangkutan.</div>
                            </div>
                        </main>
                    </div>
                </div>
                <div id="loading-bulk-container" class="text-center w-100" style="display: none;">
                    <picture>
                        <img class="img-fluid ml-3 mr-2" src="{{ asset('assets/images/animated/loading-animated2.gif')}}" alt="Loading Animation">
                    </picture>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('page-script')
<script type="text/javascript" src="{{ asset('assets/js/comp/currency.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/js/jquery.printThis.js') }}"></script>
<script>
$(document).ready(function() {
    var pegawai_id = {{ $data_pegawai[0]->id }};
    var month = {{ date('n') }};
    @if (auth()->user()->role == 2)
    var month_bulk = {{ date('n') }};
    @endif

    $('#pegawai-list').change(function() {
        pegawai_id = $(this).val();

        getDataPegawai();
    });

    $('#date-box').change(function() {
        month = $(this).val();

        getDataGajiPegawai();
    });

    @if (auth()->user()->role == 2)
    $('#date-box-bulk').change(function() {
        month_bulk = $(this).val();

        getDataGajiPegawaiBulk();
    });

    $('#cetak-gaji-button').on('click', function() {
        $(".no-print").hide();
        $("#gaji-container").printThis();
        setTimeout(function(){$(".no-print").show();}, 3000);
    });

    $('#cetak-gaji-button-bulk').on('click', function() {
        $(".no-print").hide();
        $("#gaji-bulk-container").printThis();
        setTimeout(function(){$(".no-print").show();}, 3000);
    });
    @endif

    function getDataGajiPegawai() {
        if ($('#gaji-container').is(":visible"))
            toggleSearchGaji();

        $.ajax({
            method: 'GET',
            url: '{{ route('gaji') }}/' + pegawai_id + '/' + month,
            data: "_token=" + $('meta[name="csrf-token"]').attr('content')
        }).done(function(data) {
            let data_gaji = data.data_gaji;
            let data_lemburan = data_gaji.lemburan;
            let total_gaji = data_gaji.gaji_pokok;

            let row = "<tr>";
                row += "<td class=\"no\">01</td>";
                row += "<td class=\"text-left\"><h5>Gaji Pokok</h5>Gaji utama karyawan</td>";
                row += "<td class=\"unit\">" + formatCurrencyFromPlainNumber(total_gaji) + "</td>";
                row += "<td class=\"tax\"> - </td>";
                row += "<td class=\"total\">" + formatCurrencyFromPlainNumber(total_gaji) + "</td>";
                row += "</tr>";

            for (let i = 0; i < data_lemburan.length; i++) {
                let gaji_lembur = data_lemburan[i].additional_pay;
                total_gaji += gaji_lembur;

                row += "<tr>";
                row += "<td class=\"no\">" + ("0" + (i + 2)).slice(-2) + "</td>";
                row += "<td class=\"text-left text-primary\"><h5>Absen Lembur</h5>" + data_lemburan[i].date + "</td>";
                row += "<td class=\"unit text-primary\">" + formatCurrencyFromPlainNumber(gaji_lembur) + "</td>";
                row += "<td class=\"tax\"> - </td>";
                row += "<td class=\"total text-primary\">" + formatCurrencyFromPlainNumber(total_gaji) + "</td>";
                row += "</tr>";
            }

            // Append Row Data
            $('#cetak-table tbody').html(row);

            $('#unit').html(formatCurrencyFromPlainNumber(total_gaji));
            $('#gaji-id').html("Struk No. " + pegawai_id + month + "{{ date('Y') }}");
            $('#date').html("Pada Bulan: " + moment("{{ date('Y') }}-" + ('0' + month).slice(-2) + "-01").format('MMMM YYYY'));

            $('#gaji-title').val("Gaji Pegawai - " + moment("{{ date('Y') }}-" + ('0' + month).slice(-2) + "-01").format("MMMM"));
            toggleSearchGaji();
        });
    }

    @if (auth()->user()->role == 2)
    function getDataGajiPegawaiBulk() {
        toggleSearchGajiBulk();

        $.ajax({
            method: 'GET',
            url: '{{ route('gaji') }}/all/' + month_bulk,
            data: "_token=" + $('meta[name="csrf-token"]').attr('content')
        }).done(function(json) {
            let data = json.data;
            let row = "";

            for (let i = 0; i < data.length; i++) {
                let gaji_pokok = data[i].data_gaji.gaji_pokok;
                let gaji_lembur = data[i].data_gaji.gaji_lembur;

                row += "<tr>";
                row += "<td class=\"text-center\">" + (i + 1) + ".</td>";
                row += "<td>";
                row += "<div class=\"widget-content p-0\">";
                row += "<div class=\"widget-content-wrapper\">";
                row += "<div class=\"widget-content-left mr-3\">";
                row += "<div class=\"widget-content-left\">";
                row += "<img class=\"rounded-circle\" src=\"{{ asset('assets/images/person.png') }}\" alt=\"\" width=\"40\">";
                row += "</div>";
                row += "</div>";
                row += "<div class=\"widget-content-left flex2\">";
                row += "<div class=\"widget-heading\">" + data[i].data_pegawai.name + " (<strong>" + data[i].data_pegawai.email + "</strong>)</div>";
                row += "<div class=\"widget-subheading opacity-7\">" + data[i].data_pegawai.jabatan.nama_jabatan + "</div>";
                row += "</div>";
                row += "</div>";
                row += "</div>";
                row += "</td>";
                row += "<td class=\"text-center\">" + formatCurrencyFromPlainNumber(gaji_pokok) + "</td>";
                row += "<td class=\"text-center\">-</td>";
                row += "<td class=\"text-center\">" + formatCurrencyFromPlainNumber(gaji_lembur) + "</td>";
                row += "<td class=\"text-center\">" + formatCurrencyFromPlainNumber(gaji_pokok + gaji_lembur) + "</td>";
                row += "</tr>";
            }

            // Append Row Data
            $('#cetak-bulk-table tbody').html(row);
            $('#date-bulk').html("Pada Bulan: " + moment("{{ date('Y') }}-" + ('0' + month_bulk).slice(-2) + "-01").format('MMMM YYYY'));
            $('#download-gaji-button-bulk').attr('href', '{{ route('gaji') }}/print/' + month_bulk + '/all');

            $('#gaji-title-bulk').val("Gaji Pegawai - " + moment("{{ date('Y') }}-" + ('0' + month_bulk).slice(-2) + "-01").format("MMMM"));
            toggleSearchGajiBulk();
        });
    }
    @endif

    function getDataPegawai() {
        toggleSearchProfile();

        $.ajax({
            method: 'GET',
            url: '{{ route('pegawai.detail', ['id' => ' ']) }}' + pegawai_id,
            data: "_token=" + $('meta[name="csrf-token"]').attr('content')
        }).done(function(data) {
            let pegawai = data.data;

            // Profile Box Info
            $("#pegawai-title").html("Profile Pegawai - " + pegawai.name)
            $("#pegawai-name-box").html(pegawai.name);
            $("#pegawai-nomor-induk-box").html(pegawai.nomor_induk);
            $("#pegawai-jabatan-box").html(pegawai.jabatan.nama_jabatan);
            $("#pegawai-contact-box").html(pegawai.email);

            // Gaji Box Info
            $('#pegawai').html(pegawai.name);
            $('#jabatan').html(pegawai.jabatan.nama_jabatan);
            $('#email a').html(pegawai.email);
            $('#email a').attr('href', "mailto:" + pegawai.email);

            toggleSearchProfile();
            getDataGajiPegawai();
        });
    }

    function toggleSearchProfile() {
        $('#pegawai-list').prop('disabled', function(i, v) { return !v; });
        $('#profile-box').toggle();
        $('#loading-container-profile').toggle();

        toggleSearchGaji();
    }

    function toggleSearchGaji() {
        $('#date-box').prop('disabled', function(i, v) { return !v; });
        $('#gaji-container').toggle();
        $('#loading-container').toggle();
    }

    @if (auth()->user()->role == 2)
    function toggleSearchGajiBulk() {
        $('#date-box-bulk').prop('disabled', function(i, v) { return !v; });
        $('#gaji-bulk-container').toggle();
        $('#loading-bulk-container').toggle();
    }
    @endif

    // First Run Instance
    setTimeout(function() {
        getDataGajiPegawai();
        @if (auth()->user()->role == 2)
        getDataGajiPegawaiBulk();
        @endif
    }, 200);
});
</script>
@endsection
