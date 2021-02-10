<?php

namespace Qihucms\ScanRecharge\Controllers\Wap;

use Illuminate\Support\Facades\Auth;
use Qihucms\ScanRecharge\Models\ScanRechargeChannel;
use Qihucms\ScanRecharge\Models\ScanRechargeOrder;
use Qihucms\ScanRecharge\Requests\StoreRequest;

class RechargeController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $channel = ScanRechargeChannel::latest()->get();
        return view('scan-recharge::recharge', compact('channel'));
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $result = ScanRechargeOrder::create([
            'scan_recharge_channel_id' => $request->input('payment_channel'),
            'user_id' => Auth::id(),
            'amount' => $request->input('custom_amount'),
            'desc' => $request->input('desc'),
            'status' => 0
        ]);

        if ($result) {
            return back()->with('status', 'SUCCESS');
        }

        return back()->with('status', 'ERROR');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function log()
    {
        $items = ScanRechargeOrder::where('user_id', Auth::id())->latest()->paginate();

        return view('scan-recharge::log', compact('items'));
    }
}