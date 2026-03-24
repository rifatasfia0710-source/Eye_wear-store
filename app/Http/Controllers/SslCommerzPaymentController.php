<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

   
public function index(Request $request)
{
    $user = auth()->user();

    $cartItems = \App\Models\Cart::with('product')
        ->where('user_id', $user->id)
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Cart is empty');
    }

    $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

    $tran_id = uniqid('TXN_', true);

    $post_data = [];
    $post_data['total_amount']     = $total;
    $post_data['currency']         = "BDT";
    $post_data['tran_id']          = $tran_id;

    $post_data['cus_name']         = $user->name;
    $post_data['cus_email']        = $user->email;
    $post_data['cus_add1']         = $request->address ?? 'N/A';
    $post_data['cus_add2']         = "";
    $post_data['cus_city']         = $request->city ?? 'Dhaka';
    $post_data['cus_state']        = "";
    $post_data['cus_postcode']     = $request->zip ?? "1000";
    $post_data['cus_country']      = "Bangladesh";
    $post_data['cus_phone']        = $request->phone ?? '01700000000';
    $post_data['cus_fax']          = "";

    $post_data['ship_name']        = $user->name;
    $post_data['ship_add1']        = $request->address ?? 'Dhaka';
    $post_data['ship_add2']        = "";
    $post_data['ship_city']        = $request->city ?? 'Dhaka';
    $post_data['ship_state']       = "Dhaka";
    $post_data['ship_postcode']    = $request->zip ?? "1000";
    $post_data['ship_phone']       = "";
    $post_data['ship_country']     = "Bangladesh";

    $post_data['shipping_method']  = "NO";
    $post_data['product_name']     = "Eyewear Order";
    $post_data['product_category'] = "Goods";
    $post_data['product_profile']  = "physical-goods";

    // Order টা DB তে save করুন
    $order = \App\Models\Order::create([
        'user_id'        => $user->id,
        'total_amount'   => $total,
        'payment_method' => 'sslcommerz',
        'payment_status' => 'unpaid',
        'status'         => 'pending',
        'address'        => $request->address ?? 'N/A',
        'transaction_id' => $tran_id,
    ]);

    // Order items save
    foreach ($cartItems as $item) {
        \App\Models\OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $item->product_id,
            'quantity'   => $item->quantity,
            'price'      => $item->product->price,
        ]);
    }

    $sslc = new SslCommerzNotification();
    $payment_options = $sslc->makePayment($post_data, 'hosted');

    if (!is_array($payment_options)) {
        print_r($payment_options);
    }
}
    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    
// public function success(Request $request)
// {
//     $tran_id  = $request->input('tran_id');
//     $amount   = $request->input('amount');
//     $currency = $request->input('currency');

//     $sslc = new SslCommerzNotification();
//     $order_details = DB::table('orders')
//         ->where('transaction_id', $tran_id)
//         ->select('transaction_id', 'status', 'currency', 'amount')
//         ->first();

//     if ($order_details->status == 'pending') {
//         $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

//         if ($validation) {
//             DB::table('orders')
//                 ->where('transaction_id', $tran_id)
//                 ->update(['status' => 'Processing', 'payment_status' => 'paid']);

//             // Cart clear করুন
//             // DB::table('carts')->where('user_id', auth()->id())->delete();
// // ✅ Use user_id from order, not from session
//             DB::table('carts')->where('user_id', $order->user_id)->delete();
//             return redirect()->route('checkout.success')
//                 ->with('success', 'Payment Successful! Order confirmed.');
//         }
//     }

//     return redirect()->route('checkout.success');
// }
    


public function fail(Request $request)
{
    $tran_id = $request->input('tran_id');
    DB::table('orders')->where('transaction_id', $tran_id)->update(['status' => 'Failed']);
    
    return redirect()->route('checkout.index')->with('error', 'Payment Failed! Please try again.');
}

public function cancel(Request $request)
{
    $tran_id = $request->input('tran_id');
    DB::table('orders')->where('transaction_id', $tran_id)->update(['status' => 'Canceled']);
    
    return redirect()->route('checkout.index')->with('error', 'Payment Cancelled.');
}
    // public function ipn(Request $request)
    // {
    //     #Received all the payement information from the gateway
    //     if ($request->input('tran_id')) #Check transation id is posted or not.
    //     {

    //         $tran_id = $request->input('tran_id');

    //         #Check order status in order tabel against the transaction id or order id.
    //         $order_details = DB::table('orders')
    //             ->where('transaction_id', $tran_id)
    //             ->select('transaction_id', 'status', 'currency', 'amount')->first();

    //         if ($order_details->status == 'pending') {
    //             $sslc = new SslCommerzNotification();
    //             $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
    //             if ($validation == TRUE) {
    //                 /*
    //                 That means IPN worked. Here you need to update order status
    //                 in order table as Processing or Complete.
    //                 Here you can also sent sms or email for successful transaction to customer
    //                 */
    //                 $update_product = DB::table('orders')
    //                     ->where('transaction_id', $tran_id)
    //                     ->update(['status' => 'Processing']);

    //                 echo "Transaction is successfully Completed";
    //             }
    //         } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

    //             #That means Order status already updated. No need to udate database.

    //             echo "Transaction is already successfully Completed";
    //         } else {
    //             #That means something wrong happened. You can redirect customer to your product page.

    //             echo "Invalid Transaction";
    //         }
    //     } else {
    //         echo "Invalid Data";
    //     }
    // }
public function success(Request $request)
{
    $tran_id  = $request->input('tran_id');
    $amount   = $request->input('amount');
    $currency = $request->input('currency');

    $sslc = new SslCommerzNotification();

    $order = DB::table('orders')
        ->where('transaction_id', $tran_id)
        ->first(); // ✅ পুরো row নিচ্ছি, শুধু select নয়

    if (!$order) {
        return redirect()->route('checkout.index')->with('error', 'Order not found.');
    }

    if ($order->status == 'pending') {
        $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

        if ($validation) {
            // ✅ status + payment_status দুটোই update
            DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update([
                    'status'         => 'processing',
                    'payment_status' => 'paid', // ✅ এটাই admin এ দেখাবে
                ]);

            // ✅ $order->user_id দিয়ে cart clear
            DB::table('carts')->where('user_id', $order->user_id)->delete();

            return redirect()->route('checkout.success')
                ->with('success', 'Payment Successful! Order confirmed.');
        }
    } elseif ($order->status == 'processing') {
        // IPN আগেই update করে ফেলেছে
        return redirect()->route('checkout.success')
            ->with('success', 'Payment already confirmed.');
    }

    return redirect()->route('checkout.index')->with('error', 'Payment validation failed.');
}

public function ipn(Request $request)
{
    if ($request->input('tran_id')) {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->first();

        if (!$order_details) return;

        if ($order_details->status == 'pending') {
            $sslc = new SslCommerzNotification();
            $validation = $sslc->orderValidate(
                $request->all(),
                $tran_id,
                $order_details->total_amount, // ✅ amount field ঠিক করা
                $order_details->currency ?? 'BDT'
            );

            if ($validation) {
                // ✅ payment_status যোগ করা হয়েছে
                DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update([
                        'status'         => 'processing',
                        'payment_status' => 'paid',
                    ]);

                echo "Transaction is successfully Completed";
            }
        } elseif (in_array($order_details->status, ['processing', 'complete'])) {
            echo "Transaction is already successfully Completed";
        } else {
            echo "Invalid Transaction";
        }
    } else {
        echo "Invalid Data";
    }
}
}
