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


       $response = zainpayment::config($config)
    ->callBackUrl(url("/") . '/payment/callback')
    ->purchase($invoice, function($driver, $transactionId) use($amount,$phone,$name,$item) {
        $payment = new Payment();
        $payment->transaction_id = $transactionId;
        $payment->item = $item;
        $payment->amount = $amount;
        $payment->name = $name;
        $payment->phone = $phone;
        $payment->uuid = Str::uuid()->toString();
        $payment->save();
    })
    ->pay();

// حالا به آدرس درگاه ریدایرکت کن
return redirect()->away($response->getAction());

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
                
                return redirect()->route('thankyou')->with('error','موجودی یا خطا در تایید پرداخت: '.$Status ?? '');

            }
            $receipt = zainpayment::config($config)->amount($payment->amount)
                ->transactionId($payment->transaction_id)
                ->verify();

            $payment->ref_id = $receipt->getReferenceId();
            // $payment->pay_at = Carbon::now();
            $payment->save();
            
             return redirect()->route('thankyou')
    ->with('success','پرداخت با موفقیت انجام شد.')
    ->with('payment_uuid', $payment->uuid);

        
        } catch (InvalidPaymentException $exception) {
            Log::error($exception->getMessage(),request()->all());
           return redirect()->route('thankyou')->with('error','موجودی یا خطا در تایید پرداخت: '.$res['Status'] ?? '');
        }

      
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
