@extends('layouts.app')

@section('title', 'Verify OTP - Greenleaf')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor" class="text-success" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        </div>
                        <h2 class="h4 fw-bold text-dark mb-2">
                            @if($intent === 'login')
                                Verify your login
                            @else
                                Verify your phone
                            @endif
                        </h2>
                        <p class="text-muted mb-0">
                            We sent a 6-digit code to WhatsApp ending in <strong>{{ $masked_phone }}</strong>. Enter it below.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.otp.verify.submit') }}" class="mb-4">
                        @csrf
                        <div class="mb-4">
                            <label for="otp" class="form-label fw-bold">Verification code</label>
                            <input type="text"
                                   class="form-control form-control-lg text-center letter-spacing @error('otp') is-invalid @enderror"
                                   id="otp"
                                   name="otp"
                                   value="{{ old('otp') }}"
                                   placeholder="000000"
                                   maxlength="6"
                                   pattern="[0-9]*"
                                   inputmode="numeric"
                                   autocomplete="one-time-code"
                                   required
                                   autofocus>
                            @error('otp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Verify & continue
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <p class="text-muted small mb-0">
                            Code not received? Wait a minute and
                            <a href="{{ $intent === 'login' ? route('auth.login') : route('auth.register') }}">try again</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.letter-spacing { letter-spacing: 0.5em; }
</style>
@endsection
