<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\Gateway as Gateway;


class PaymentController extends Controller
{

    // public function index(){
    //     return 'ciaone';
    // }
    public function pay(Request $request){

        $data = $request->all();
        // dd($data);

        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'fs4whkzypxsqc7xn',
            'publicKey' => '97tp4wjp72rh7zh9',
            'privateKey' => '7977e7b9a05118f5981ff44adf7b0cf1'
        ]);
    

        // $nonceFromTheClient = $_POST["payment_method_nonce"];

        $result = $gateway->transaction()->sale([
            'amount' => '12.00',
            // 'paymentMethodNonce' => $data['payment_method_nonce'],
            'paymentMethodNonce' => 'fake-valid-nonce',
            // 'deviceData' => $deviceDataFromTheClient,
            'options' => [
              'submitForSettlement' => True
            ]
          ]);
          
          //parte presa dall'esempio per ritornare solo se success true
        //   if ($result->success == false){
        //       dd('non a buon fine');
        //   }      

          if ($result->success) {
              $transaction = $result->transaction;
              dd($result);

            header("Location: " . $baseUrl . "transaction.php?id=" . $transaction->id);
        } else {
            $errorString = "";
        
            foreach($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }
            dd('la transazione non è andata a buon fine');
        
            $_SESSION["errors"] = $errorString;
            header("Location: " . $baseUrl . "index.php");
        }



        return redirect(route('home'));

    }
}
