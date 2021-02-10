<?php

namespace Qihucms\ScanRecharge\Jobs;

use App\Repositories\AccountRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Qihucms\ScanRecharge\Models\ScanRechargeOrder;

class RechargeSuccessUserAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @param ScanRechargeOrder $order
     * @return void
     */
    public function __construct(ScanRechargeOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @throws \Exception
     * @return void
     */
    public function handle()
    {
        if ($this->order->status != 1) return null;

        $account = new AccountRepository();

        $amount = bcmul($this->order->amount, cache('config_recharge_jewel_rate', 0), 2);

        $account->updateJewel(
            $this->order->user_id,
            $amount,
            'scan_recharge',
            [
                'tips' => $this->order->desc,
            ]
        );
    }
}
