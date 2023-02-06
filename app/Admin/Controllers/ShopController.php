<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Shop;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class ShopController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Shop(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('relate_id');
            $grid->column('cert');
            $grid->column('photo');
            $grid->column('real_name');
            $grid->column('ID_card_no');
            $grid->column('shop_name');
            $grid->column('type');
            $grid->column('province_id')->distpicker();
            $grid->column('city_id')->distpicker();
            $grid->column('area_id')->distpicker();
            $grid->column('address');
            $grid->column('phone');
            $grid->column('status')->select([
                //0 待审核 1 正常 2 驳回
                0 => '待审核',
                1 => '正常',
                2 => '驳回',
            ], true)->width("120px");
            $grid->column('extra.mark','备注');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
            $grid->disableViewButton();
            $grid->disableBatchActions();
//            $grid->disableActions();
            $grid->disableCreateButton();
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Shop(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('relate_id');
            $form->text('real_name');
            $form->text('ID_card_no');
            $form->text('shop_name');
            $form->text('type');
            $form->distpicker(['province_id', 'city_id', 'area_id'])->autoselect(3)->required();
            $form->text('address');
            $form->text('phone');
            $form->select('status', '状态')->options([
                0 => '待审核',
                1 => '正常',
                2 => '驳回',
            ]);
            $form->text('extra.mark','备注');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
