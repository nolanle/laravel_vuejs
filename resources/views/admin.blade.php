@extends('layouts.app')

@section('content')
    @include('components.header')

    <div class="container-fluid">
        <div class="row">
            <sidebar></sidebar>

            <div class="content-wrapper">

                <router-view></router-view>

                @include('components.footer')
                {{--<footer></footer>--}}

            </div> <!-- /content-wrapper -->

        </div> <!-- /row -->

    </div> <!-- /container-fluid -->
@endsection
