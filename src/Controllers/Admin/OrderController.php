<?php

namespace Qihucms\ScanRecharge\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\ScanRecharge\Jobs\RechargeSuccessUserAccountJob;
use Qihucms\ScanRecharge\Models\ScanRechargeChannel;
use Qihucms\ScanRecharge\Models\ScanRechargeOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '充值订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ScanRechargeOrder());

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {
            $filter->equal('scan_recharge_channel_id', __('scan-recharge::order.scan_recharge_channel_id'))
                ->select(ScanRechargeChannel::select('id', 'name')->pluck('name', 'id'));
            $filter->equal('user_id', __('scan-recharge::order.user_id'));
            $filter->like('name', __('scan-recharge::order.name'));
        });

        $grid->column('id', __('scan-recharge::order.id'));
        $grid->column('user.username', __('scan-recharge::order.user_id'));
        $grid->column('scan_recharge_channel.name', __('scan-recharge::order.scan_recharge_channel_id'));
        $grid->column('amount', __('scan-recharge::order.amount'));
        $grid->column('status', __('scan-recharge::order.status'))
            ->using(__('scan-recharge::order.status_value'));
        $grid->column('created_at', __('admin.created_at'));
        $grid->column('updated_at', __('admin.updated_at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ScanRechargeOrder::findOrFail($id));

        $show->field('id', __('scan-recharge::order.id'));
        $show->field('scan_recharge_channel_id', __('scan-recharge::order.scan_recharge_channel_id'))
            ->as(function () {
                return $this->scan_recharge_channel->name ?? null;
            });
        $show->field('user_id', __('scan-recharge::order.user_id'))
            ->as(function () {
                return $this->user->username ?? null;
            });
        $show->field('amount', __('scan-recharge::order.amount'));
        $show->field('desc', __('scan-recharge::order.desc'));
        $show->field('reply', __('scan-recharge::order.reply'));
        $show->field('status', __('scan-recharge::order.status'))
            ->using(__('scan-recharge::order.status_value'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ScanRechargeOrder());
        $form->select('scan_recharge_channel_id', __('scan-recharge::order.scan_recharge_channel_id'))
            ->options(ScanRechargeChannel::select('id', 'name')->pluck('name', 'id'))
            ->required();
        $form->text('user_id', __('scan-recharge::order.user_id'))
            ->required()
            ->help(__('scan-recharge::order.user_id_help'));
        $form->currency('amount', __('scan-recharge::order.amount'))->symbol('¥')
            ->default(0)
            ->required();
        $form->textarea('desc', __('scan-recharge::order.desc'))
            ->required()
            ->help(__('scan-recharge::order.desc_help'));
        $form->textarea('reply', __('scan-recharge::order.reply'))
            ->help(__('scan-recharge::order.reply_help'));
        $form->select('status', __('scan-recharge::order.status'))
            ->options(__('scan-recharge::order.status_value'));
        $form->saving(function (Form $form) {
            if ($form->status == 1 && $form->model()->id) {
                RechargeSuccessUserAccountJob::dispatch(ScanRechargeOrder::find($form->model()->id));
            }
        });
        return $form;
    }
}
