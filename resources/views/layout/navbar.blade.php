<div class="app-header-right">
    <div class="header-btn-lg pr-0">
        <div class="widget-content p-0">
            <div class="widget-content-wrapper">
                <div class="widget-content-left header-user-info">
                    <div class="widget-heading">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="widget-subheading">
                        {{ auth()->user()->jabatan->nama_jabatan }}
                    </div>
                </div>
                <div class="widget-content-left ml-2">
                    <div class="btn-group">
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                            <img width="42" class="rounded-circle" src="{{ asset('assets/images/person.png') }}" alt="person.png">
                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                        </a>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                            <a id="logout" href="javascript:void(0)" tabindex="0" class="dropdown-item">Log out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
