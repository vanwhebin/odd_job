<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Trade;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TradeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Trade(), function (Grid $grid) {
            //排序
            $grid->model()->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('status')->switch();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();


            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
            $grid->disableViewButton();
            $grid->disableBatchActions();
//            $grid->disableCreateButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Trade(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->switch('status')->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
