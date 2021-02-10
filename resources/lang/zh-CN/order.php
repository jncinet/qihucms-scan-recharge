<?php

return [
    'id' => 'ID',
    'scan_recharge_channel_id' => '支付渠道',
    'user_id' => '支付会员',
    'user_id_help' => '先确定会员ID号，可在会员列表中查询会员ID',
    'amount' => '支付金额',
    'desc' => '备注',
    'desc_help' => '充值付款成功后必须备注付款信息，否则无法确认充值是否成功',
    'reply' => '回复',
    'reply_help' => '如果充值失败，可在此说明原因',
    'status' => '交易状态',
    'status_value' => ['等待审核', '充值成功', '充值失败']
];