@extends('layout.master')
@section('title', 'Dashboard')
@section('description', 'Halaman Dashboard')
@section('icon', 'pe-7s-home')

@section('page-content')
<div class="row justify-content-center">
    <div class="col-sm-12 col-xl-6 main-card mb-3 card">
        <div class="card-header bg-danger text-white">
            Pegawai Bermasalah
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
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data_pegawai_problematic) == 0)
                        <tr>
                            <td class="bg-light text-secondary text-center" colspan="4">Tidak ada Pegawai bermasalah.</td>
                        </tr>
                    @else
                        @php ( $i = 0 )
                        @foreach ($data_pegawai_problematic as $pegawai)
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
                            <td class="text-center text-danger font-weight-bold">
                                Cuti tersedia mencapai angka minus
                            </td>
                            <td class="text-center">
                                <div class="badge badge-danger">Bermasalah</div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-12 col-xl-6">
        <div class="main-card mb-3 card">
            <div class="grid-menu grid-menu-2col">
                <div class="no-gutters row">
                    <div class="col-sm-6">
                        <div class="widget-chart widget-chart-hover">
                            <div class="icon-wrapper rounded-circle">
                                <div class="icon-wrapper-bg bg-primary"></div>
                                <i class="pe-7s-id text-primary"></i>
                            </div>
                            <div class="widget-numbers">{{ $jml_pegawai }}</div>
                            <div class="widget-subheading">Total Pegawai</div>
                            <div class="widget-description text-secondary">
                                <span class="pl-1">- | -</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget-chart widget-chart-hover">
                            <div class="icon-wrapper rounded-circle">
                                <div class="icon-wrapper-bg bg-info"></div>
                                <i class="pe-7s-clock text-info"></i>
                            </div>
                            <div class="widget-numbers">{{ $jml_absensi_month }}</div>
                            <div class="widget-subheading">Total Absensi Bulan Ini</div>
                            @if ($absen_state >= 1)
                            <div class="widget-description text-success">
                                <i class="fa fa-angle-up"></i>
                                <span class="pl-1">{{ $absen_diff_percentage }}% Meningkat</span>
                            </div>
                            @elseif ($absen_state <= -1)
                            <div class="widget-description text-danger">
                                <i class="fa fa-angle-down"></i>
                                <span class="pl-1">{{ $absen_diff_percentage }}% Menurun</span>
                            </div>
                            @else
                            <div class="widget-description text-info">
                                <i class="fa fa-info"></i>
                                <span class="pl-1">{{ $absen_diff_percentage }}% Terjaga</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget-chart widget-chart-hover">
                            <div class="icon-wrapper rounded-circle">
                                <div class="icon-wrapper-bg bg-danger"></div>
                                <i class="pe-7s-note2 text-danger"></i>
                            </div>
                            <div class="widget-numbers">{{ $jml_izin_month }} Laporan</div>
                            <div class="widget-subheading">Data Izin Bulan Ini</div>
                            <div class="widget-description text-warning">
                                <span class="pr-1">Dari {{ $jml_pegawai_izin }} Pegawai</span>
                                <i class="fa fa-arrow-left"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget-chart widget-chart-hover br-br">
                            <div class="icon-wrapper rounded-circle">
                                <div class="icon-wrapper-bg bg-success"></div>
                                <i class="pe-7s-user"></i>
                            </div>
                            <div class="widget-numbers">Manager</div>
                            <div class="widget-subheading">Akses Website</div>
                            <div class="widget-description text-secondary">
                                <span class="pr-1">- | -</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistic Performance -->
    <div class="col col-lg-12">
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title">
                    <i class="header-icon pe-7s-clock icon-gradient bg-tempting-azure"> </i>
                    Performa Absensi Seluruh Pegawai - Jan / Dec
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="tab-eg-55">
                    <div class="widget-chart p-3">
                        <div style="height: 350px;">
                            <canvas id="chart-absen"></canvas>
                        </div>
                    </div>
                    <div class="pt-2 card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-numbers fsize-3 text-muted">
                                                    {{ $jan_mar }}% Pegawai Masuk
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="text-muted opacity-6">Januari -
                                                    Maret</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper mt-1">
                                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{ $jan_mar }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $jan_mar }}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-numbers fsize-3 text-muted">
                                                    {{ $apr_jun }}% Pegawai Masuk
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="text-muted opacity-6">April - Juni</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper mt-1">
                                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ $apr_jun }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $apr_jun }}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-numbers fsize-3 text-muted">{{ $jul_sep }}% Pegawai Masuk</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="text-muted opacity-6">Juli -
                                                    September
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper mt-1">
                                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="{{ $jul_sep }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $jul_sep }}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-numbers fsize-3 text-muted">{{ $oct_dec }}% Pegawai Masuk</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="text-muted opacity-6">October -
                                                    December
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper mt-1">
                                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{ $oct_dec }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $oct_dec }}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    var month_data_absen = @json($data_monthly_absensi['have_absensi']);
    var month_total_days = @json($data_monthly_absensi['total_days']);
    var month_data_absen_null = [];

    for (var i = 0; i < month_data_absen.length; i++) {
        month_data_absen_null.push(((month_data_absen[i] / month_total_days[i]) * 100));
    }

    month_data_absen = month_data_absen.slice(0, {{ date('m') }});
    month_data_absen_null = month_data_absen_null.slice(0, {{ date('m') }});

    var line_chart = new Chart($("#chart-absen"), {
        type: "line",
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: [{
                label: "Rata-rata Persentase Masuk",
                fill: !1,
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: month_data_absen
            }]
        },
        options: {
            responsive: !0,
            maintainAspectRatio: !1,
            title: {
                display: !1,
                text: "Chart.js Line Chart"
            },
            legend: {
                display: !1
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 0
                }
            },
            tooltips: {
                mode: "index",
                intersect: !1
            },
            hover: {
                mode: "nearest",
                intersect: !0
            },
            pointBackgroundColor: "#fff",
            pointBorderColor: window.chartColors.blue,
            pointBorderWidth: "2",
            scales: {
                xAxes: [{
                    display: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Month"
                    }
                }],
                yAxes: [{
                    display: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Value"
                    }
                }]
            }
        }
    });
});
</script>
@endsection
