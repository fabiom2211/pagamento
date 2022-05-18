<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\Customer;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\SDK;

class PagamentoController extends Controller
{
    public function index()
    {
        return view('pagamento-form');
    }

    public function boleto()
    {
//        SDK::setAccessToken(env("ACCESS_TOKEN_MERCADO_PAGO"));
//        $payment_methods = SDK::get("/v1/payment_methods");
//print_r($payment_methods);exit;
        return view('pagamento-boleto-form');
    }
    public function BoletoPay(Request $request)
    {
        SDK::setAccessToken(env("ACCESS_TOKEN_MERCADO_PAGO"));
        $payment = new Payment();
        $payment->transaction_amount = $request->transactionAmount;
        $payment->description = "Produto Teste Fabio";
        $payment->payment_method_id = $request->paymentMethod;
        $payment->payer = array(
            "email" => $request->payerEmail,
            "first_name" => $request->payerFirstName,
            "last_name" => $request->payerLastName,
            "identification" => array(
                "type" => $request->docType,
                "number" => $request->docNumber
            ),
            "address"=>  array(
                "zip_code" => "06233200",
                "street_name" => "Av. das Nações Unidas",
                "street_number" => "3003",
                "neighborhood" => "Bonfim",
                "city" => "Osasco",
                "federal_unit" => "SP"
            )
        );

        $payment->save();

        if ($payment->status == "pending"){
            return redirect($payment->transaction_details->external_resource_url);
        }else{
            return redirect('/error');
        }


    }

    public function store(Request $request)
    {

        SDK::setAccessToken(env("ACCESS_TOKEN_MERCADO_PAGO"));

        $payment = new Payment();

        if ($request->paymentMethod == "bolbradesco"){
            $payment->transaction_amount = $request->transactionAmount;
            $payment->description = "Produto Teste Fabio";
            $payment->payment_method_id = $request->paymentMethod;
            $payment->payer = array(
                "email" => $request->payerEmail,
                "first_name" => $request->payerFirstName,
                "last_name" => $request->payerLastName,
                "identification" => array(
                    "type" => $request->docType,
                    "number" => $request->docNumber
                ),
                "address"=>  array(
                    "zip_code" => "06233200",
                    "street_name" => "Av. das Nações Unidas",
                    "street_number" => "3003",
                    "neighborhood" => "Bonfim",
                    "city" => "Osasco",
                    "federal_unit" => "SP"
                )
            );

            $payment->save();

            if ($payment->status == "pending"){
                return redirect($payment->transaction_details->external_resource_url);
            }

        }else{

            $payment->transaction_amount = (float)$request->MPHiddenInputAmount;
            $payment->token = $request->MPHiddenInputToken;
            $payment->description = "Fabio Testando API";
            $payment->installments = (int)$request->installments;

            $payer = new Payer();
            $payer->email = $request->cardholderEmail;
            $payer->identification = array(
                "type" => $request->identificationType,
                "number" => $request->identificationNumber
            );

            $payer->first_name = $request->cardholderName;
            $payment->payer = $payer;
            $payment->save();

            if ($payment->status == "approved"){
                return redirect('/success');
            }
        }

        return redirect('/error');
    }
}
