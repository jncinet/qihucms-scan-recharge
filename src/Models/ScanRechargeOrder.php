<?php

namespace Qihucms\ScanRecharge\Models;

use Illuminate\Database\Eloquent\Model;

class ScanRechargeOrder extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'scan_recharge_channel_id', 'user_id', 'amount', 'desc', 'reply', 'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function scan_recharge_channel()
    {
        return $this->belongsTo('Qihucms\ScanRecharge\Models\ScanRechargeChannel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}