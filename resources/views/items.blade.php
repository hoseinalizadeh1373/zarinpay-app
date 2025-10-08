@extends('layouts.app')
@section('title','انتخاب خدمت')

@section('content')
<div class="text-center mb-4">
    <h2>انتخاب آیتم برای پرداخت</h2>
</div>

<div class="row justify-content-center">
@foreach($items as $item)
  <div class="col-md-4 mb-4">
    <div class="card shadow-sm">
      <div class="card-body text-center">
        <h5 class="card-title">{{ $item['title'] }}</h5>
        <p class="card-text">مبلغ: {{ number_format($item['amount']) }} تومان</p>
        <a href="{{ url('/purchase/'.$item['id']) }}" class="btn btn-primary w-100">انتخاب</a>
      </div>
    </div>
  </div>
@endforeach
</div>
@endsection
