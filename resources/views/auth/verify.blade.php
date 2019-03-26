@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">رایان نامه خود را تایید کنید</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                           لینک بارگذاری مجدد کلمه عبور به ایمیل شما ارسال شد.
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">ارسال درخواست بارگذاری مجدد</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
