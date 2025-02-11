@extends('layouts.user.master')

@section('title', 'Dashboard')

@section('container')

    <!-- welcome user -->
    <div class="mb-4 shadow-sm card">
        <div class="card-header">
            <div class="row">
                <div class="col-auto">
                    <div class="shadow avatar avatar-60 rounded-10">
                        <img src="{{ asset('img/logo.png') }}" alt="">
                    </div>
                </div>
                <div class="col align-self-center ps-0">
                    <h4 class="text-color-theme"><span class="fw-normal">Hi</span>, {{ auth()->user()->name }}</h4>
                </div>
                <div class="col-auto">
                    {{-- {!! QrCode::generate(route('users.show', auth()->id())) !!} --}}
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 row">
        <div class="col-6 col-md-6 col-lg-6">
            <a href="{{ route('product.input.form') }}">
                <div class="mb-1 card">
                    <div class="text-center card-body">
                        <div class="avatar avatar-60 alert-dark text-dark rounded-circle">
                            {{-- {{ $jmlPinjaman }} --}}
                            <i class="nav-icon bi bi-inbox"></i>
                        </div>
                        <p class="mt-2 small text-muted">Input</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-6 col-lg-6">
            <a href="{{ route('product.input.history') }}">
                <div class="mb-1 card">
                    <div class="text-center card-body">
                        <div class="avatar avatar-60 alert-success text-dark rounded-circle">
                            {{-- {{ $jmlProductDipinjam }} --}}
                            <i class="nav-icon bi bi-inboxes"></i>
                        </div>
                        <p class="mt-2 small text-muted">History</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
