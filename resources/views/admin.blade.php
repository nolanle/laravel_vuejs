@extends('layouts.app')

@section('content')
    @include('components.header')

    <div class="container-fluid">
        <div class="row">
            <sidebar></sidebar>

            <div class="content-wrapper">

                <div class="row">
                    <div class="mb-30 col-xl-12">
                        <div class="card-statistics h-100 card">
                            <div class="card-body">

                                <router-view></router-view>

                            </div>
                        </div>
                    </div>
                </div>

                @include('components.footer')

            </div> <!-- /content-wrapper -->

        </div> <!-- /row -->

    </div> <!-- /container-fluid -->
@endsection
