<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use srmklive\PayPal\Services\PayPal;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function showForm()
    {
        return view('pages.depositForm');
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $provider = \PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $provider->setCurrency('EUR');
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $depositAmount = $data['value'];
        $orderdata = json_decode('{
            "intent": "CAPTURE",
            "purchase_units": [
              {
                "amount": {
                  "currency_code":"EUR",
                  "value":"' . $depositAmount . '"
                }
              }
            ]
        }', true);



        /*$order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => $depositAmount
                    ]
                ]
            ]
        ]);*/


        $order = $provider->createOrder($orderdata);

        return response()->json($order);
    }

    public function capture(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $orderID = $data['orderID'];

        $provider = \PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $provider->setCurrency('EUR');
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);



        $result = $provider->capturePaymentOrder($orderID);
        /** 
         * ! for some reason calling Auth::id() here returns null, ask professor why
         */
        /*
        if ($result['status'] == 'COMPLETED') {

            $depositVal = floatval($result['purchase_units'][0]['payments']['captures'][0]['amount']['value']);

            $deposit = new Deposit();
            $deposit->value = $depositVal;
            $deposit->date = Carbon::now();
            $deposit->author = Auth::id();
            $deposit->save();
        }*/

        return response()->json($result);
    }
}
