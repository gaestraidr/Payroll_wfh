@extends('layout.master')
@section('title', 'Dashboard')
@section('description', 'Halaman Dashboard')
@section('icon', 'pe-7s-home')

@section('page-content')
<div class="row justify-content-center">
    <div class="col-sm-12 mb-3 card">
        <div class="card-header-tab card-header">
            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                Performa Bulan Ini
            </div>
            <div class="btn-actions-pane-right text-capitalize">
                <a href="{{ route('absensi.detail') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">Lihat Absensi</a>
            </div>
        </div>
        <div class="no-gutters row">
            <div class="col-sm-6 col-md-4 col-xl-4">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                        <i class="pe-7s-stopwatch text-dark opacity-8"></i>
                    </div>
                    @php ( $int_month = intval(date('m')) )
                    <div class="widget-chart-content">
                        <div class="widget-subheading">Absensi Bulan Ini</div>
                        <div class="widget-numbers">{{ $data_monthly_absensi['have_absensi'][$int_month - 1] }} Absen</div>
                        <div class="widget-description opacity-8 text-focus">
                            <div class="d-inline text-{{ $data_monthly_absensi['have_absensi'][$int_month - 1] >= $data_monthly_absensi['have_absensi'][$int_month - 2] ? 'success' : 'danger' }} pr-1">
                                <i class="fa fa-angle-{{ $data_monthly_absensi['have_absensi'][$int_month - 1] >= $data_monthly_absensi['have_absensi'][$int_month - 2] ? 'up' : 'down' }}"></i>
                                @if ($data_monthly_absensi['have_absensi'][$int_month - 2] != 0)
                                <span class="pl-1">{{ $data_monthly_absensi['have_absensi'][$int_month - 1] / $data_monthly_absensi['have_absensi'][$int_month - 2] }}%</span>
                                @else
                                <span class="pl-1">100%</span>
                                @endif
                            </div>
                            @if ($data_monthly_absensi['have_absensi'][$int_month - 1] > $data_monthly_absensi['have_absensi'][$int_month - 2])
                            Menaik
                            @elseif ($data_monthly_absensi['have_absensi'][$int_month - 1] < $data_monthly_absensi['have_absensi'][$int_month - 2])
                            Menurun
                            @else
                            Terjaga
                            @endif
                        </div>
                    </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-4">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-9 bg-danger"></div>
                        <i class="pe-7s-note2 text-white"></i>
                    </div>
                    <div class="widget-chart-content">
                        <div class="widget-subheading">Cuti Tersedia</div>
                        <div class="widget-numbers"><span>{{ auth()->user()->jumlah_cuti }}</span></div>
                        <div class="widget-description opacity-8 text-focus">
                            Status:
                            <span class="text-{{ auth()->user()->jumlah_cuti >= 0 ? 'info' : 'danger' }} pl-1">
                                <i class="fa fa-{{ auth()->user()->jumlah_cuti >= 0 ? 'check' : 'times' }}"></i>
                                <span class="pl-1">{{ auth()->user()->jumlah_cuti >= 0 ? 'Tidak Bermasalah' : 'Bermasalah' }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
            </div>
            <div class="col-sm-12 col-md-4 col-xl-4">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-9 bg-success"></div>
                        <i class="pe-7s-stopwatch text-white"></i>
                    </div>
                    <div class="widget-chart-content">
                        <div class="widget-subheading">Quota Absensi Hari Ini</div>
                        <div class="widget-numbers text-success"><span>{{ 2 - $quota_absensi }}</span></div>
                        <div class="widget-description text-focus">
                            Status:
                            <span class="text-{{ $quota_absensi == 2 ? 'success' : 'warning' }} pl-1">
                                <i class="fa fa-{{ $quota_absensi == 2 ? 'check' : 'info-circle' }}"></i>
                                <span class="pl-1">{{ $quota_absensi == 2 ? 'Terpenuhi' : 'Lakukan Absensi'}}</span>
                            </span>
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
                    Performa Absensi - Jan / Dec [{{ auth()->user()->name }}]
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
                                                    {{ $jan_mar }}% Masuk
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
                                                    {{ $apr_jun }}% Masuk
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
                                                <div class="widget-numbers fsize-3 text-muted">{{ $jul_sep }}% Masuk</div>
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
                                                <div class="widget-numbers fsize-3 text-muted">{{ $oct_dec }}% Masuk</div>
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
        month_data_absen_null.push((month_total_days[i] - month_data_absen[i]));
    }

    month_data_absen = month_data_absen.slice(0, {{ date('m') }});
    month_data_absen_null = month_data_absen_null.slice(0, {{ date('m') }});

    var line_chart = new Chart($("#chart-absen"), {
        type: "line",
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: [{
                label: "Tanpa Keterangan",
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: month_data_absen_null,
                fill: !1
            }, {
                label: "Masuk",
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
