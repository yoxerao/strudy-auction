<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Srmklive\PayPal\Service\PayPal;
use App\Models\User;

class DepositController extends Controller
{
        public function showForm($id)
    {
        // Retrieve the user's information from the database
        $user = User::find($id);

        // Render the deposit form
        return view('pages.depositForm', compact('user'));
    }


    public function create(Request $request){
        error_log('ZZZ');
        $data = json_decode($request->getContent(), true);  
        $provider = \PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $amount = Deposit::getDepositAmount($data['value']);
        $author = $data['author'];


        
        error_log('xx');

        $data = json_decode('{
            "intent": "CAPTURE",
            "purchase_units": [
              {
                "amount": {
                  "currency_code": "USD",
                  "value": "100.00"
                }
              }
            ]
        }', true);
        
        error_log('yy');
        $order = $provider->createOrder($data);

        /*$deposit = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => $amount,
                    ],
                    'author' => $author,
                ],
            ],
        ]);*/

        //save deposit to database


        return response()->json($deposit);
    }


}