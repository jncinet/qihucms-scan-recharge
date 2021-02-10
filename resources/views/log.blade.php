@extends('layouts.wap')

@section('title', '充值记录')

@section('header_title', '充值记录')

@section('content')
    <div class="bg-white px-3 py-2">
        @forelse($items as $item)
            <div class="d-flex justify-content-between pt-2">
                <div>
                    {{ $item->scan_recharge_channel->name }}
                    @if($item->status == 2)
                        <span class="badge badge-danger">
                            {{ __('scan-recharge::order.status_value')[$item->status] }}：
                            {{ $item->reply }}
                        </span>
                    @elseif($item->status == 1)
                        <span class="badge badge-success">{{ __('scan-recharge::order.status_value')[$item->status] }}</span>
                    @else
                        <span class="badge badge-dark">{{ __('scan-recharge::order.status_value')[$item->status] }}</span>
                    @endif
                </div>
                <div>
                    {{ bcmul($item->amount, cache('config_recharge_jewel_rate', 0), 2) }}{{ cache('config_jewel_unit') }}
                </div>
            </div>
            <div class="d-flex justify-content-between pt-1 pb-2 qh-border-bottom text-black-50 font-size-14">
                <div>
                    {{ $item['created_at'] }}
                </div>
                <div class="text-danger">
                    ¥{{ $item['amount'] }}元
                </div>
            </div>
        @empty
            @include('components.wap.no_content', ['content' => '暂无充值记录'])
        @endforelse
        <div class="pt-3 d-flex justify-content-center">
            {{ $items->links() }}
        </div>
    </div>
    @include('components.wap.placeholder_nav')
    @include('components.wap.nav', ['index' => 'member'])
@endsection
