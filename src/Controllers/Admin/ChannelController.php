<?php

namespace Qihucms\ScanRecharge\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\ScanRecharge\Models\ScanRechargeChannel;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ChannelController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '支付渠道';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ScanRechargeChannel());

        $grid->filter(function ($filter) {
            $filter->like('name', __('scan-recharge::channel.name'));
        });

        $grid->column('id', __('scan-recharge::channel.id'));
        $grid->column('name', __('scan-recharge::channel.name'));
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
        $show = new Show(ScanRechargeChannel::findOrFail($id));

        $show->field('id', __('scan-recharge::channel.id'));
        $show->field('name', __('scan-recharge::channel.name'));
        $show->field('desc', __('scan-recharge::channel.desc'))->unescape();
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
        $form = new Form(new ScanRechargeChannel());

        $form->text('name', __('scan-recharge::channel.name'))
            ->help(__('scan-recharge::channel.name_help'))
            ->required();
        $form->UEditor('desc', __('scan-recharge::channel.desc'))
            ->help(__('scan-recharge::channel.desc_help'))
            ->required();
        $form->display('created_at', __('admin.created_at'));
        $form->display('updated_at', __('admin.updated_at'));

        return $form;
    }
}
