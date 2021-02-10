@extends('layouts.wap')

@section('title', '手动充值')

@section('header_title', '手动充值')

@section('styles')
    <style>
        .w-33 {
            width: 33.3333%;
        }
    </style>
@endsection
@section('content')
    <div class="p-3 bg-white mb-3 shadow-sm">
        <div class="font-size-14 mb-2 text-secondary">{{ cache('config_jewel_alias') }}余额</div>
        <div class="d-flex align-items-center">
            <i class="iconfont icon-zuanshi font-size-22 text-info mr-2" aria-hidden="true"></i>
            <div class="font-size-22">{{ Auth::user()['account']['jewel'] ?: 0 }}</div>
        </div>
    </div>
    <form method="post" id="rechargeForm">
        @csrf
        <div class="px-3 text-secondary pb-2">请选择支付渠道</div>
        <div class="px-3 mb-2 pb-1">
            <div class="bg-light w-100 rounded-top border p-3">
                @foreach($channel as $item)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input @if ($loop->first)
                               checked
                               @endif
                               type="radio" id="r{{ $item->id }}" name="payment_channel" value="{{ $item->id }}"
                               class="custom-control-input">
                        <label class="custom-control-label" for="r{{ $item->id }}">{{ $item->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="bg-light w-100 rounded-bottom border border-top-0 p-3" id="c">
                @foreach($channel as $item)
                    <div id="c{{ $item->id }}" @if (!$loop->first)
                    class="d-none"
                            @endif
                    >{!! $item->desc !!}</div>
                @endforeach
            </div>
        </div>
        <div class="px-3 text-secondary pb-1">请选择充值金额</div>
        <div class="px-1">
            <div class="d-flex flex-wrap px-2" id="amountWrap">
                <div class="w-33 p-1" data-value="10">
                    <div class="bg-primary text-center rounded line-height-1 py-3">
                        <div class="text-white mb-1">{{ cache('config_recharge_jewel_rate') * 10 }}
                            <small>{{ cache('config_jewel_unit') }}</small>
                        </div>
                        <small class="text-white-50">¥ 10</small>
                    </div>
                </div>
                <div class="w-33 p-1" data-value="20">
                    <div class="bg-secondary text-center rounded line-height-1 py-3">
                        <div class="text-white mb-1">{{ cache('config_recharge_jewel_rate') * 20 }}
                            <small>{{ cache('config_jewel_unit') }}</small>
                        </div>
                        <small class="text-white-50">¥ 20.00</small>
                    </div>
                </div>
                <div class="w-33 p-1" data-value="66">
                    <div class="bg-secondary text-center rounded line-height-1 py-3">
                        <div class="text-white mb-1">{{ cache('config_recharge_jewel_rate') * 66 }}
                            <small>{{ cache('config_jewel_unit') }}</small>
                        </div>
                        <small class="text-white-50">¥ 66.00</small>
                    </div>
                </div>
                <div class="w-33 p-1" data-value="168">
                    <div class="bg-secondary text-center rounded line-height-1 py-3">
                        <div class="text-white mb-1">{{ cache('config_recharge_jewel_rate') * 168 }}
                            <small>{{ cache('config_jewel_unit') }}</small>
                        </div>
                        <small class="text-white-50">¥ 168.00</small>
                    </div>
                </div>
                <div class="w-33 p-1" data-value="520">
                    <div class="bg-secondary text-center rounded line-height-1 py-3">
                        <div class="text-white mb-1">{{ cache('config_recharge_jewel_rate') * 520 }}
                            <small>{{ cache('config_jewel_unit') }}</small>
                        </div>
                        <small class="text-white-50">¥ 520.00</small>
                    </div>
                </div>
                <div class="w-33 p-1" data-value="custom">
                    <div class="bg-secondary text-center rounded line-height-1 py-3">
                        <div class="text-white mb-1">自定义
                            <small>输入</small>
                        </div>
                        <small class="text-white-50">最低 ¥{{ cache('config_recharge_jewel_min') }}</small>
                    </div>
                </div>
            </div>
            <div class="px-2 pt-2 mx-1 d-none" id="customAmount">
                <input type="text" id="custom_amount" name="custom_amount"
                       class="bg-light w-100 rounded border p-2 font-size-18"
                       value="10">
            </div>
        </div>
        <div class="px-3 text-secondary pb-2  mt-2">请填写支付说明</div>
        <div class="px-3 pb-1">
            <textarea required class="form-control" id="desc" name="desc" rows="3" placeholder="充值说明"></textarea>
        </div>
        <div class="p-3">
            <button class="btn btn-primary btn-block qh-btn-rounded" type="submit">
                确认充值<span id="btn-amount">（10元）</span>
            </button>
        </div>
    </form>
    @include('components.wap.placeholder_nav')
    @include('components.wap.nav', ['index' => 'member'])
@endsection

@push('scripts')
    <script>
        @if(session('status'))
        $.toast("{{ session('status') == 'SUCCESS' ? '提交成功' : '提交失败' }}", "text");
        @endif

        $(document).ready(function () {
            $('input[name="payment_channel"]').on('change', function () {
                // 新选择的支付方式
                const t = $('input[name="payment_channel"]:checked').val();
                $("#c > div").addClass('d-none');
                $("#c" + t).removeClass('d-none');
            });

            // 保留两位小数
            $("#custom_amount").on('change', function () {
                $(this).val(parseInt($(this).val()));
                $("#btn-amount").text("（" + $(this).val() + "元）");
            });

            // 切换金额
            $("#amountWrap > div").on('click', function () {
                $("#amountWrap > div > div").removeClass('bg-primary').addClass('bg-secondary');
                $(this).children('div').removeClass('bg-secondary').addClass('bg-primary');
                $("#custom_amount").val($(this).attr('data-value'));
                if ($(this).attr('data-value') === 'custom') {
                    $("#customAmount").removeClass('d-none');
                    $("#custom_amount").val("{{ cache('config_recharge_jewel_min') }}");
                } else {
                    $("#customAmount").addClass('d-none');
                }
                $("#btn-amount").text("（" + $("#custom_amount").val() + "元）");
            });

            $('#rechargeForm').on('submit', function () {
                if ($('#custom_amount').val() < parseInt({{ cache('config_recharge_jewel_min') }})) {
                    $.toast("充值金额错误", "text");
                    return false;
                }
            });
        });
    </script>
@endpush