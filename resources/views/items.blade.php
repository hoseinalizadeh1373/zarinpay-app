@extends('layouts.app')
@section('title','انتخاب خدمت')

@section('content')
<div class="text-center my-5">
    <h2 class="fw-bold display-5">ثبت نام دوره آموزش ادمینی و رشد سریع پیج</h2>
    <p class="lead text-muted mt-3">اپشن های VIP: ثبت نام کلاس های حضوری و آنلاین آموزش ادمینی و رشد سریع پیج</p>
</div>

<div class="row justify-content-center mb-4 align-items-center">
   
    <div class="col-md-6">
        <ul class="list-group list-group-flush mb-0">
            <li class="mb-2">
                <i class="bi bi-award-fill text-primary me-2"></i>
                مدرک معتبر وزارت علوم و دانشگاه
            </li>
            <li class="mb-2">
                <i class="bi bi-mortarboard-fill text-success me-2"></i>
                مدرک معتبر فنی و حرفه ای
            </li>
            <li>
                <i class="bi bi-lightbulb-fill text-warning me-2"></i>
                120 ایده مخصوص هر پیج برای پست/استوری/ریلز/لایو
            </li>
        </ul>
    </div>
     <div class="col-md-2 text-center">
        <img src="{{ asset('images/person.jpg') }}" alt="صاحب سایت" class="rounded-circle" style="width:120px; height:120px; object-fit:cover;">
    </div>
</div>

</div>


        <p class="text-center fw-bold fs-5" >هدف آموزش‌ها: آماده سازی زیرساخت پیج برای فروش کمپینی</p>
    </div>
</div>

<div class="row justify-content-center">
@foreach($items as $item)
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <h5 class="card-title"></h5>
                
                {{-- می‌تونی این متن رو بر اساس id تغییر بدی --}}
       @if($item['id'] == 'inpersonCourse')
    <p class="card-text">
        <i class="bi bi-building me-2"></i> دوره حضوری <br>
        <i class="bi bi-people-fill me-2"></i> ظرفیت: ۴۰ نفر <br>
        <i class="bi bi-currency-dollar me-2"></i> مبلغ: {{ number_format($item['amount']) }} تومان <br>
        <i class="bi bi-geo-alt me-2"></i> محل برگزاری: کاشمر - آموزشگاه فنی حرفه ای
    </p>
@elseif($item['id'] == 'onlineCourse')
    <p class="card-text">
        <i class="bi bi-laptop me-2"></i> دوره آنلاین <br>
        <i class="bi bi-people-fill me-2"></i> ظرفیت: ۴۰ نفر <br>
        <i class="bi bi-currency-dollar me-2"></i> مبلغ: {{ number_format($item['amount']) }} تومان <br>
        <i class="bi bi-cloud-arrow-down me-2"></i> دسترسی از طریق گوگل میت + ویدیوها و اسلایدهای جلسات
    </p>
@endif

                <a href="{{ url('/purchase/'.$item['id']) }}" class="btn btn-success w-100">ثبت نام</a>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
