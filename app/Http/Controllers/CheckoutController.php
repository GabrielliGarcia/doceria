<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Payment;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Configurar o SDK com seu token de acesso
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

    }

    public function criarPagamento(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'token' => 'required',
            'payment_method_id' => 'required',
            'email' => 'required|email',
        ]);

        $payment = new Payment();
        $payment->transaction_amount = 100; // Valor em reais
        $payment->token = $request->input('token'); // Token do cartão
        $payment->description = "Descrição do Produto";
        $payment->payment_method_id = $request->input('payment_method_id');
        $payment->payer = [
            "email" => $request->input('email'),
        ];

        // Salva o pagamento e retorna a resposta
        if ($payment->save()) {
            return response()->json($payment);
        } else {
            return response()->json(['error' => $payment->error], 400);
        }
    }
}
