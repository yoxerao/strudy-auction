<?php

namespace App\Http\Controllers;

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


    public function processForm(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'amount' => 'required|numeric',
        ]);
        $provider = \PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $deposit = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => $request->amount,
                    ],
                ],
            ],
            'application_context' => [
                'cancel_url' => route('depositCancel', ['id' => $id]),
                'return_url' => route('depositSuccess', ['id' => $id]),
            ],
        ]);

        
        

        return redirect($deposit['links'][1]['href']);
    }

    public function success(Request $request, $id)
    {
        // Verify the payment and update the database
        $response = PayPal::processPayment($request->paymentId, $request->PayerID);

        if ($response['status'] == 'approved') {
            // Payment approved, update the database
            $user = User::find($id);
            $user->balance += $request->amount;
            $user->save();
        } else {
            // Payment failed, redirect the user with an error message
            return redirect()->route('depositForm', ['id' => $id])->with('error', 'Payment failed');
        }

        // Redirect the user with a success message
        return redirect()->route('depositForm', ['id' => $id])->with('status', 'Deposit successful');
    }

    public function cancel($id)
    {
        // Redirect the user with a cancel message
        return redirect()->route('depositForm', ['id' => $id])->with('error', 'Payment cancelled');
    }


}