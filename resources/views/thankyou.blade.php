@extends('layouts.app')
@section('title','نتیجه پرداخت')

@section('content')
<div class="text-center mt-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h3>با تشکر از شما 🙏</h3>
    <a href="{{ url('/') }}" class="btn btn-primary mt-4">بازگشت به صفحه اصلی</a>
</div>
@endsection
