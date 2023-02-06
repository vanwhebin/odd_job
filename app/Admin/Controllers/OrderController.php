<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Order;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Order(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('no');
            $grid->column('user_id');
            $grid->column('shop_id');
            $grid->column('position_id');
            $grid->column('date');
            $grid->column('start');
            $grid->column('end');
            $grid->column('badge');
            $grid->column('amount');
            $grid->column('wage');
            $grid->column('age');
            $grid->column('content');
            $grid->column('total');
            $grid->column('paid_at');
            $grid->column('status');
            $grid->column('extra');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Order(), function (Show $show) {
            $show->field('id');
            $show->field('no');
            $show->field('user_id');
            $show->field('shop_id');
            $show->field('position_id');
            $show->field('date');
            $show->field('start');
            $show->field('end');
            $show->field('badge');
            $show->field('amount');
            $show->field('wage');
            $show->field('age');
            $show->field('content');
            $show->field('total');
            $show->field('paid_at');
            $show->field('status');
            $show->field('extra');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Order(), function (Form $form) {
            $form->display('id');
            $form->text('no');
            $form->text('user_id');
            $form->text('shop_id');
            $form->text('position_id');
            $form->text('date');
            $form->text('start');
            $form->text('end');
            $form->text('badge');
            $form->text('amount');
            $form->text('wage');
            $form->text('age');
            $form->text('content');
            $form->text('total');
            $form->text('paid_at');
            $form->text('status');
            $form->text('extra');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
