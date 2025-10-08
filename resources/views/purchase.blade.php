@extends('layouts.app')
@section('title','فرم پرداخت')

@section('content')
<div class="card mx-auto" style="max-width: 500px;">
  <div class="card-body">
    
    <h5 class="card-title text-center mb-3">فرم پرداخت {{ $item['title'] }}</h5>
    <form method="POST" action="{{ url('/purchase') }}">
      @csrf
      <input type="hidden" name="item" value="{{ $itemKey }}">
      <input type="hidden" name="amount" value="{{ $item['amount'] }}">

      <div class="mb-3">
        <label for="name" class="form-label">نام</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">شماره تماس</label>
        <input type="text" name="phone" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success w-100">پرداخت</button>
    </form>
  </div>
</div>
@endsection
