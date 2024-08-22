<?php

namespace App\Http\Controllers\Mobile;

use App\Services\Mobile\FatoraApiService;
use App\Http\Controllers\Controller;
use App\Models\WalletCharge;
use Illuminate\Http\Request;

class WalletFatoraController extends Controller
{
    protected $paymentService;

    public function __construct(FatoraApiService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPayment(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
        ]);

        $response = $this->paymentService->createPayment($data);

        if (isset($response['error']) && $response['error']) {
            return response()->json([
                'message' => $response['message']
            ], $response['status_code']);
        }

        return response()->json($response);
    }

    public function handlePaymentCallback(Request $request)
    {
        WalletCharge::create([
            'wallet_id' => 1,
            'image' => 'WalletCharge/0cqMBuDlZq0m2rVJHc9D2ZstJ9GMzh3iwc7wgqE9.png',
            'status' => 'تم الشحن',
        ]);
        // Process the payment status received from Fatora
        //$data = $request->all();
        // Update payment status in the database, etc.
        // Example: Payment::where('transaction_id', $data['transaction_id'])->update(['status' => $data['status']]);

        // return response()->json(['message' => 'Callback received successfully']);
    }

    // Handle the payment trigger
    public function handlePaymentTrigger(Request $request)
    {
        // Process any additional actions after payment
        $data = $request->all();

        // Trigger any additional tasks such as notifying other services
        // Example: dispatch(new NotifyUserOfPayment($data));

        return response()->json(['message' => 'Trigger received successfully']);
    }


    public function paymentStatus($id)
    {

        $response = $this->paymentService->paymentStatus($id);

        if (isset($response['error']) && $response['error']) {
            return response()->json([
                'message' => $response['message']
            ], $response['status_code']);
        }

        return response()->json($response);
    }
}
