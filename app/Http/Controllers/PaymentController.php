<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Shetabit\Multipay\Invoice;
use Log;
use Shetabit\Payment\Facade\Payment as zainpayment;

class PaymentController extends Controller
{
    public function index()
    {
        // دو آیتم ثابت — اگر خواستی از DB هم بیاری
        $items = [
            ['id'=>'itemA','title'=>'آیتم A','amount'=>10000],
            ['id'=>'itemB','title'=>'آیتم B','amount'=>20000],
        ];
        return view('items', compact('items'));
    }

    public function showForm($item)
    {
        $items = [
            'itemA' => ['title'=>'آیتم A','amount'=>10000],
            'itemB' => ['title'=>'آیتم B','amount'=>20000],
        ];
        if (!isset($items[$item])) abort(404);
        $data = $items[$item];
        return view('purchase', ['itemKey'=>$item, 'item'=>$data]);
    }

    public function startPayment(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'phone'=>'required|string|max:30',
            'item'=>'required|string',
            'amount'=>'required|integer|min:1',
        ]);

        // $payment = Payment::create([
        //     'item'=>$request->item,
        //     'name'=>$request->name,
        //     'phone'=>$request->phone,
        //     'amount'=>$request->amount,
        //     'status'=>'pending'
        // ]);

          $amount = $request->amount;
          $phone = $request->phone;
           $item = $request->item;
          $name = $request->name;
        $invoice = new Invoice;
        $invoice->amount($amount);

        $config = [
            "merchantId"=> env('ZARINPAL_MERCHANT_ID') ?? "12345678901234567890123456",
            // "mode" => env('ZARINPAL_MERCHANT_ID') ? "zaringate" : "sandbox",
            "mode" => 'sandbox'
        ];


        // $merchant = env('ZARINPAL_MERCHANT_ID');
        // $callbackUrl = url('/payment/callback?payment_id='.$payment->id);
        // $description = "خرید {$request->item} - سفارش #{$payment->id}";


       $response = zainpayment::config($config)
    ->callBackUrl(url("/") . '/payment/callback')
    ->purchase($invoice, function($driver, $transactionId) use($amount,$phone,$name,$item) {
        $payment = new Payment();
        $payment->transaction_id = $transactionId;
        $payment->item = $item;
        $payment->amount = $amount;
        $payment->name = $name;
        $payment->phone = $phone;
        $payment->uuid = random_int(100000000,9999999999);
        $payment->save();
    })
    ->pay();

// حالا به آدرس درگاه ریدایرکت کن
return redirect()->away($response->getAction());



        // $email = null;
        // $mobile = $request->phone;

        // // endpoint (sandbox vs production)
        // $isSandbox = env('ZARINPAL_SANDBOX', true);
        // $base = $isSandbox ? 'https://sandbox.zarinpal.com/pg/rest/WebGate/' : 'https://www.zarinpal.com/pg/rest/WebGate/';

        // // درخواست ایجاد پرداخت
        // $response = Http::post($base.'PaymentRequest.json', [
        //     'MerchantID' => $merchant,
        //     'Amount' => $payment->amount,
        //     'CallbackURL' => $callbackUrl,
        //     'Description' => $description,
        //     'Email' => $email,
        //     'Mobile' => $mobile,
        // ]);

        // if ($response->ok()) {
        //     $res = $response->json();
        //     if (isset($res['Status']) && $res['Status'] == 100 && isset($res['Authority'])) {
        //         $authority = $res['Authority'];
        //         $payment->update(['authority'=>$authority]);
        //         $startPay = $isSandbox ? "https://sandbox.zarinpal.com/pg/StartPay/{$authority}" : "https://www.zarinpal.com/pg/StartPay/{$authority}";
        //         return redirect()->away($startPay);
        //     } else {
        //         $payment->update(['status'=>'failed', 'meta'=>$res]);
        //         return back()->with('error','خطا در ایجاد پرداخت: '.$res['Status'] ?? 'unknown');
        //     }
        // } else {
        //     $payment->update(['status'=>'failed','meta'=>$response->body()]);
        //     return back()->with('error','خطا در اتصال به درگاه پرداخت.');
        // }
    }

    public function callback(Request $request)
    {

        
        $authority = $request->get('Authority');
        $status = $request->get('Status');
        // $payment_id = $request->get('payment_id');

        $payment = Payment::where('transaction_id', $authority)->first();
        if (!$payment) abort(404);


         $config = [
            "merchantId"=> env('ZARINPAL_MERCHANT_ID') ?? "12345678901234567890123456",
            "mode" =>  "sandbox",
        ];


        

        try {
            Log::info($request->get('status')."status");
            if(request()->get('Status') =='NOK'){
                
                return redirect()->route('thankyou')->with('error','موجودی یا خطا در تایید پرداخت: '.$res['Status'] ?? '');

            }
            $receipt = zainpayment::config($config)->amount($payment->amount)
                ->transactionId($payment->transaction_id)
                ->verify();

            $payment->ref_id = $receipt->getReferenceId();
            // $payment->pay_at = Carbon::now();
            $payment>save();
            
            $user = User::find($paymentRecord->user_id);
            $user->increaseBalance($paymentRecord->amount,$paymentRecord, Transaction::TYPE_WALLET_RECHARGE);
              return redirect()->route('thankyou')->with('success','پرداخت با موفقیت انجام شد.');
        
        } catch (InvalidPaymentException $exception) {
            Log::error($exception->getMessage(),request()->all());
            return redirect()->to("/wallet/error");
        }

        // if ($status == 'OK') {
        //     $merchant = env('ZARINPAL_MERCHANT_ID');
        //     $isSandbox = env('ZARINPAL_SANDBOX', true);
        //     $base = $isSandbox ? 'https://sandbox.zarinpal.com/pg/rest/WebGate/' : 'https://www.zarinpal.com/pg/rest/WebGate/';

        //     $response = Http::post($base.'PaymentVerification.json', [
        //         'MerchantID' => $merchant,
        //         'Authority' => $authority,
        //         'Amount' => $payment->amount,
        //     ]);

        //     if ($response->ok()) {
        //         $res = $response->json();
        //         if (isset($res['Status']) && ($res['Status'] == 100 || $res['Status'] == 101)) {
        //             // پرداخت موفق
        //             $payment->update([
        //                 'status'=>'paid',
        //                 'ref_id'=>$res['RefID'] ?? null,
        //                 'meta'=>$res
        //             ]);
        //             return redirect()->route('thankyou')->with('success','پرداخت با موفقیت انجام شد.');
        //         } else {
        //             $payment->update(['status'=>'failed','meta'=>$res]);
        //             return redirect()->route('thankyou')->with('error','موجودی یا خطا در تایید پرداخت: '.$res['Status'] ?? '');
        //         }
        //     } else {
        //         $payment->update(['status'=>'failed','meta'=>$response->body()]);
        //         return redirect()->route('thankyou')->with('error','خطا در تایید پرداخت.');
        //     }
        // } else {
        //     $payment->update(['status'=>'failed','meta'=>['status'=>$status,'authority'=>$authority]]);
        //     return redirect()->route('thankyou')->with('error','پرداخت لغو شد یا ناموفق بود.');
        // }
    }

    public function thankyou()
    {
        return view('thankyou');
    }

    public function adminIndex()
    {
        $payments = Payment::orderBy('created_at','desc')->paginate(20);
        return view('admin.payments', compact('payments'));
    }
}
