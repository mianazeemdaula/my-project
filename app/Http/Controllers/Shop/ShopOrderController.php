<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;
use App\Models\Rider;
use App\Helper\FCM;

class ShopOrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // $orders =  Order::where('shop_id',$user->id)->where('status', 'pending')->get();
        $orders =  Order::where('status','open')->get();
        return view('merchants.orders.order', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('merchants.orders.orderdetails', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = $request->status;
        if($request->status == 'accept'){
            $order->approved_at = now();
            $fcmTokens = [];
            $riderIds = Rider::whereNotNull('live_geo')->pluck('user_id');
            $riders = User::whereNotNull('fcm_token')->whereIn('id',$riderIds)->get();
            foreach ($riders as $rider) {
                $fcmTokens[] = $rider->fcm_token;
            }
            $order->req_riders = $riderIds;
            $order->save();
            $data = [
                'type' => 'new_order',
                'id' => $order->id,
                '_from' => $order->shop->shop->address,
                '_to' => $order->drop_address,
            ];
            FCM::send($fcmTokens, 'New Order Request', 'You have a new order request to deliver', $data);
        }else if($request->status == 'processed'){
            $order->processes_at = now();
        }else if($request->status == 'processed'){
            $order->processes_at = now();
        }else if($request->status == 'canceled'){
            $order->canceled_at = now();
            $order->req_riders = null;
        }
        $order->save();
        return redirect()->back();
    }


    public function status($status)
    {
        $orders = Order::all();
        return view('admin.dispatcher.approved',compact('orders', 'status'));
    }
}
