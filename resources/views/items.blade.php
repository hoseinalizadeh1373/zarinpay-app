@extends('layouts.app')
@section('title','انتخاب خدمت')

@section('content')
<div class="text-center my-5">
    <h2 class="fw-bold display-5">ثبت نام دوره آموزش ادمینی و رشد سریع پیج</h2>
    <p class="lead text-muted mt-3">اپشن های VIP: ثبت نام کلاس های حضوری و آنلاین آموزش ادمینی و رشد سریع پیج</p>
</div>

<div class="row justify-content-center mb-4">
    <div class="col-md-8">
        <ul class="list-group list-group-flush mb-4">
    <li class="">
        <i class="bi bi-award-fill text-primary me-2"></i>
        مدرک معتبر وزارت علوم و دانشگاه
    </li>
    <li class="">
        <i class="bi bi-mortarboard-fill text-success me-2"></i>
        مدرک معتبر فنی و حرفه ای
    </li>
    <li class="">
        <i class="bi bi-lightbulb-fill text-warning me-2"></i>
        120 ایده مخصوص هر پیج برای پست/استوری/ریلز/لایو
    </li>
</ul>

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
                         دوره حضوری <br>
                        ظرفیت: ۴۰ نفر <br>
                        مبلغ: {{ number_format($item['amount']) }} تومان <br>
                        محل برگزاری: کاشمر - آموزشگاه فنی حرفه ای
                    </p>
                @elseif($item['id'] == 'onlineCourse')
                    <p class="card-text">
                         دوره آنلاین <br>
                        ظرفیت: ۴۰ نفر <br>
                        مبلغ: {{ number_format($item['amount']) }} تومان <br>
                        دسترسی از طریق گوگل میت + ویدیوها و اسلایدهای جلسات
                    </p>
                @endif

                <a href="{{ url('/purchase/'.$item['id']) }}" class="btn btn-success w-100">ثبت نام</a>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
