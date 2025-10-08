@extends('layouts.app')
@section('title','نتیجه پرداخت')

@section('content')
<div class="text-center mt-5">

    {{-- اگر هیچ session ای برای پرداخت وجود ندارد، کاربر مستقیم آمده --}}
    @if(!session()->has('success') && !session()->has('error'))
        {{-- می‌توانید redirect کنید یا پیام خطا بدهید --}}
        <div class="alert alert-danger">
            شما نمی‌توانید مستقیماً به این صفحه دسترسی داشته باشید.
        </div>
        <a href="{{ url('/') }}" class="btn btn-primary mt-4">بازگشت به صفحه اصلی</a>
        @php return; @endphp
    @endif

    {{-- پیام موفقیت --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- پیام خطا --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- نمایش UUID تراکنش اگر وجود دارد --}}
    @if(session('payment_uuid'))
        <div class="alert alert-info mt-3">
            شناسه پیگیری شما: <strong>{{ session('payment_uuid') }}</strong><br>
            می‌توانید با این شناسه وضعیت پرداخت خود را پیگیری کنید.
        </div>
    @endif

    <h3 class="mt-4">با تشکر از شما 🙏</h3>
    <a href="{{ url('/') }}" class="btn btn-primary mt-4">بازگشت به صفحه اصلی</a>
</div>
@endsection
