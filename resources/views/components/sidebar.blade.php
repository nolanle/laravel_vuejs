<div class="side-menu-fixed">
    <div class="scrollarea scrollbar side-menu-bg" style="overflow: hidden;">
        <div class="scrollarea-content saidbar" tabindex="1" style="margin-top: 0px; margin-left: 0px;">
            <div class="saidbar">
                <ul class="nav navbar-nav side-menu" id="collapsedMenu">

                    @if(Auth::user()->can('view-dashboard'))
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i class="ti-home"></i><span class="right-nav-text">{{ __('DASHBOARD') }}</span></a>
                        </li>
                    @endif

                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{ __('CHỨC NĂNG CHÍNH') }}</li>

                    <li class="{{ Request::segment(1) === 'companies' ? 'active' : '' }}">
                        <a aria-expanded="{{ Request::segment(1) === 'companies' ? 'true' : 'false' }}" href="#companiesCollapse" aria-controls="companiesCollapse" role="button" class="collapsed" data-toggle="collapse">
                            <div class="pull-left"><i class="ti-palette"></i><span class="right-nav-text">{{ __('QUẢN LÝ CÔNG TY') }}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <div class="collapse {{ Request::segment(1) === 'companies' ? 'show' : '' }}" id="companiesCollapse">
                            <ul id="elements">
                                <li class="{{ Request::segment(1) === 'companies' ? 'active' : '' }}"><a href="{{ route('companies') }}">{{ __('DANH SÁCH CÔNG TY') }}</a></li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>