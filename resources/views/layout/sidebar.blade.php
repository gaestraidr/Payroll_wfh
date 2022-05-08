<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboard</li>
                <li>
                    <a href="{{ route('home') }}" class="{{ Request::is('dashboard//') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-home"></i>
                        Beranda
                    </a>
                </li>
                <li class="app-sidebar__heading">Perusahaan</li>
                <li {{ Request::is('dashboard/absensi*') || Request::is('dashboard/izin/lapor') ? 'class=mm-active' : '' }}>
                    <a href="#" {{ Request::is('dashboard/absensi*') || Request::is('dashboard/izin/lapor') ? 'aria-expanded=true' : '' }}>
                        <i class="metismenu-icon pe-7s-alarm"></i>
                        Absensi
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="{{ Request::is('dashboard/absensi*') || Request::is('dashboard/izin/lapor') ? 'mm-show' : '' }}">
                        <li>
                            <a href="{{ route('izin.lapor') }}" class="{{ Request::is('dashboard/izin/lapor') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-bell"></i>
                                Lapor Izin Absen
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('absensi') }}" class="{{ Request::is('dashboard/absensi') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-bell"></i>
                                Lapor Absen Harian
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('absensi.detail') }}" class="{{ Request::is('dashboard/absensi/detail*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-graph3"></i>
                                Data Absensi
                            </a>
                        </li>
                    </ul>
                </li>
                <li {{ Request::is('dashboard/pegawai*') || Request::is('dashboard/jabatan*') || Request::is('dashboard/izin/moderate') ? 'class=mm-active' : '' }}>
                    <a href="#" {{ Request::is('dashboard/pegawai*') || Request::is('dashboard/jabatan*') || Request::is('dashboard/izin/moderate') ? 'aria-expanded=true' : '' }}>
                        <i class="metismenu-icon pe-7s-id"></i>
                        Pegawai
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="{{ Request::is('dashboard/pegawai*') || Request::is('dashboard/jabatan*') || Request::is('dashboard/izin/moderate') ? 'mm-show' : '' }}">
                        <li>
                            <a href="{{ route('gaji') }}" class="{{ Request::is('dashboard/gaji*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon"></i>
                                Data Gaji Pegawai
                            </a>
                        </li>
                        @if (auth()->user()->role == 2)
                        <li>
                            <a href="{{ route('izin.moderate') }}" class="{{ Request::is('dashboard/izin/moderate') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon"></i>
                                Data Izin Pegawai
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('jabatan') }}" class="{{ Request::is('dashboard/jabatan*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon"></i>
                                Data Jabatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pegawai') }}" class="{{ Request::is('dashboard/pegawai*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon"></i>
                                Data Pegawai
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
