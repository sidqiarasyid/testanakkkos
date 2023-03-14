<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use App\Models\Kost;
use App\Models\User;
use App\Models\DetailKost;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransactionsController extends Controller
{
    public function create(Request $request)
    {
        $kostId = $request->kost_id;
        \Midtrans\Config::$serverKey = 'SB-Mid-server-Tob-LN_iFymRBcmiE7t4znl_';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $orderId = 'trans-' . rand();
        $userId = $request->user_id;
        $userData = User::findOrFail($userId);
        $kost = Kost::findOrFail($kostId);
        $data = Transactions::create([
            'kost_id' => $kostId,
            'user_id' => $userId,
            'order_id' => $orderId,
            'kost_name' => $kost->kost_name,
            'kost_type' => $kost->kost_type,

            'location' => $kost->location,
            'status' => 'Unpaid',
            'stay_duration' => $request->stay_duration,
            'total_price' => $kost->total_price,
            'room_price' => $kost->room_price,
            'electricity' => $kost->elec_price,
            'due_date' => $request->due_date,
        ]);

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $kost->total_price,
            ),
            'item_details' => array(
                [
                    'id' => 'kost-' . rand(),
                    'name' => $kost->kost_name,
                    'price' => $kost->total_price,
                    'quantity' => 1,

                ]
            ),
            'customer_details' => array(
                'first_name' => $userData->first_name,
                'last_name' => $userData->last_name,
                'email' => $userData->email,
                'phone' => $userData->phone,
            ),

        );


        $snapTransaction = Snap::createTransaction($params);
        $snapToken = $snapTransaction->token;
        $snapPayment = $snapTransaction->redirect_url;


        return response()->json([
            'message' => 'success',
            'data' => $data,
            'payment_url' => $snapPayment,
            'snapToken' => $snapToken
        ]);
    }



    public function getByUser($userId)
    {
        $find = Transactions::where('user_id', $userId)->with('kost')->get();
        return response()->json([
            'message' => 'success',
            'data' => $find
        ]);
    }

    public function callbackHandler(Request $request)
    {
        $serverKey = 'SB-Mid-server-Tob-LN_iFymRBcmiE7t4znl_';
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                $tran = Transactions::where('order_id', $request->order_id)->first();
                $tran->update(['status' => 'Paid']);

                $details = DetailKost::where('kost_id', $tran->kost_id)->first();
                $kostId = Kost::findOrFail($tran->kost_id);


                $rented = $details->unit_rented + 1;
                $open = $details->unit_open - 1;
                $kostOpen = $kostId->unit_open - 1;
                $profit = $details->profit + $request->gross_amount;

                $details->update([
                    'profit' => $profit,
                    'unit_rented' => $rented,
                    'unit_open' => $open
                ]);

                $kostId->update([
                    'unit_open' => $kostOpen
                ]);

                return response()->json([
                    'id' => $tran
                ]);


            }
        }
    }

    public function updateChart($id)
    {
        $transData = Transactions::where('kost_id', $id)->get();

        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $months[] = [
                'month' => date('F', mktime(0, 0, 0, $i + 1, 1)),
                'value' => [
                    'type' => 'prof',
                    'profit' => 0
                ]
            ];
        }
        foreach ($transData as $data) {
            $createMonth = date('F', strtotime($data->created_at));
            foreach ($months as &$m) {
                if ($m['month'] == $createMonth) {
                    $m['value']['profit'] += (int)$data->total_price;
                    break;
                }
            }
        }

        return response()->json(
            [
                'chart' => $months,
                'transData' => $transData
            ]
        );
    }






}