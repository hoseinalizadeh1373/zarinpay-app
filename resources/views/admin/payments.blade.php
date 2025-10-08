@extends('layouts.app')
@section('title','لیست پرداخت‌ها')

@section('content')
<h3 class="text-center mb-4">لیست پرداخت‌ها</h3>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>نام</th>
      <th>شماره</th>
      <th>آیتم</th>
      <th>کد پیگیری</th>
      <th>مبلغ</th>
      <th>وضعیت</th>
      <th>Ref ID</th>
      <th>تاریخ</th>
    </tr>
  </thead>
  <tbody>
    @foreach($payments as $p)
    <tr>
      <td>{{ $p->name }}</td>
      <td>{{ $p->phone }}</td>
      <td>{{ $p->item }}</td>
      <td>{{ $p->uuid }}</td>
      <td>{{ number_format($p->amount) }}</td>
      <td>
        @if($p->status == 'paid')
          <span class="badge bg-success">موفق</span>
        @elseif($p->status == 'failed')
          <span class="badge bg-danger">ناموفق</span>
        @else
          <span class="badge bg-warning">در انتظار</span>
        @endif
      </td>
      <td>{{ $p->ref_id ?? '-' }}</td>
      <td>{{ $p->created_at->format('Y/m/d H:i') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="mt-3">
  {{ $payments->links() }}
</div>
@endsection
