@extends('layouts.app')
@section('title','نتیجه پرداخت')

@section('content')
<div class="text-center mt-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- نمایش UUID تراکنش --}}
    @if(session('payment_uuid'))
        <div class="alert alert-info mt-3">
            شناسه پیگیری شما: <strong>{{ session('payment_uuid') }}</strong><br>
            می‌توانید با این شناسه وضعیت پرداخت خود را پیگیری کنید.
        </div>
        <h3 class="mt-4">با تشکر از شما 🙏</h3>
    @endif

    
    <a href="{{ url('/') }}" class="btn btn-primary mt-4">بازگشت به صفحه اصلی</a>
</div>
@endsection
