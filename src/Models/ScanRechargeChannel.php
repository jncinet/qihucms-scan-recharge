<?php

namespace Qihucms\ScanRecharge\Models;

use Illuminate\Database\Eloquent\Model;

class ScanRechargeChannel extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'desc'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scan_recharge_orders()
    {
        return $this->hasMany('Qihucms\ScanRecharge\Models\ScanRechargeOrder');
    }
}