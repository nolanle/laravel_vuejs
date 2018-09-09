@extends('layouts.app')

@section('content')
    <header-component></header-component>

    <div class="container-fluid">
        <div class="row">
            <sidebar></sidebar>

            <div class="content-wrapper">

                <router-view></router-view>

                <footer-component></footer-component>

            </div> <!-- /content-wrapper -->

        </div> <!-- /row -->

    </div> <!-- /container-fluid -->
@endsection
