<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function checkout(Request $request)
    {

        // ======================
        // MIDTRANS CONFIG
        // ======================

        Config::$serverKey =
            env('MIDTRANS_SERVER_KEY');

        Config::$isProduction =
            env('MIDTRANS_IS_PRODUCTION');

        Config::$isSanitized = true;

        Config::$is3ds = true;

        // ======================
        // PAYMENT METHOD
        // ======================

        if (

            $request->payment_method
            === 'qris'

        ) {

            // QRIS ONLY
            $enabledPayments = [

                'gopay'

            ];

        }

        elseif (

            $request->payment_method
            === 'ewallet'

        ) {

            // E-WALLET
            $enabledPayments = [

                'gopay',

                'shopeepay'

            ];

        }

        else {

            // BANK TRANSFER
            $enabledPayments = [

                'bank_transfer'

            ];

        }

        // ======================
        // SNAP PARAMS
        // ======================

        $params = [

            'transaction_details' => [

                'order_id' =>

                    'ORDER-' . uniqid(),

                'gross_amount' =>

                    $request->total

            ],

            'customer_details' => [

                'first_name' =>

                    $request->name,

                'email' =>

                    $request->email

            ],

            // FILTER PAYMENT
            'enabled_payments' =>

                $enabledPayments

        ];

        // ======================
        // GENERATE SNAP TOKEN
        // ======================

        $snapToken =

            Snap::getSnapToken($params);

        // ======================
        // RESPONSE
        // ======================

        return response()->json([

            'token' => $snapToken

        ]);

    }
            public function saveOrder(Request $request)
        {
            $lastQueue = Order::max(

                'queue_number'

            );

            $queueNumber =

                $lastQueue
                ? $lastQueue + 1
                : 1;
            // ======================
            // SAVE ORDER
            // ======================

            $order = Order::create([

                'customer_name' =>

                    $request->customer_name,

                'customer_email' =>

                    $request->customer_email,

                'payment_method' =>

                    $request->payment_method,

                'payment_status' =>

                    'paid',
                 
                'order_status' =>

                    'pending',
                'queue_number' =>

                   $queueNumber,
                'midtrans_order_id' =>

                    $request->midtrans_order_id,

                'transaction_id' =>

                    $request->transaction_id,

                'total_price' =>

                    $request->total_price,

                'paid_at' => now()

            ]);

            // ======================
            // SAVE ITEMS
            // ======================

            foreach (

                $request->items
                as $item

            ) {

                OrderItem::create([

                    'order_id' =>

                        $order->id,

                    'menu_name' =>

                        $item['name'],

                    'price' =>

                        $item['price'],

                    'quantity' =>

                        $item['quantity'],

                    'subtotal' =>

                        $item['price']
                        *
                        $item['quantity']

                ]);

            }

            return response()->json([

                'message' =>

                    'Order berhasil disimpan'

            ]);

        }
        public function getOrders()
            {

                $orders = Order::with('items')

                    ->latest()

                    ->get();

                return response()->json(

                    $orders

                );

            }
            public function updateOrderStatus(

                Request $request,

                $id

            ) {
      

                $order = Order::findOrFail($id);

                $order->update([

                    'order_status' =>

                        $request->order_status

                ]);

                return response()->json([

                    'message' =>

                        'Status updated'

                ]);

            }
            public function myOrders(

            Request $request

        ) {

            $orders = Order::with('items')

                ->where(

                    'customer_email',

                    $request->email

                )

                ->latest()

                ->get();

            return response()->json(

                $orders

            );

        }
public function aiChat(

    Request $request

) {

    $message =

        $request->message;
        $menus =

            Menu::all();

        $menuText = '';

        foreach(

            $menus as $menu

        ) {

            $menuText .=

                $menu->name

                . ' - Rp '

                . $menu->price

                . '. ';

        }
        $email = $request->email;

        $userOrder =

            Order::where(

                'customer_email',

                $email

            )

            ->latest()

            ->first();

        $orderContext = '';

        if ($userOrder) {

            $orderContext =

                "Status pesanan user saat ini adalah "

                . $userOrder->order_status

                . ". Queue number: "

                . $userOrder->queue_number;

        }

    $response = Http::withHeaders([

        'Authorization' =>

            'Bearer '

            . env('OPENROUTER_API_KEY'),

        'HTTP-Referer' =>env('FRONTEND_URL', 'https://synel-coffe.vercel.app'),
        'X-Title' =>

            'Synel Coffee'

    ])->post(

        'https://openrouter.ai/api/v1/chat/completions',

        [

            'model' =>

                'openai/gpt-3.5-turbo',

            'messages' => [

                [

                    'role' => 'system',

                  'content' => "Kamu adalah Synel AI, assistant coffee shop premium. Menu tersedia: 
                  $orderContext
                  $menuText Jangan pernah mengarang menu lain."
                ],

                [

                    'role' => 'user',

                    'content' =>

                        $message

                ]

            ]

        ]

    );

    // ERROR
    if (!$response->successful()) {

        return response()->json([

            'reply' =>

                'OpenRouter Error: '

                . $response->body()

        ]);

    }

    $data =

        $response->json();

    return response()->json([

        'reply' =>

            $data['choices'][0]

            ['message']['content']

            ?? 'Maaf ☕ Synel AI sedang sibuk.'

    ]);

}

}