<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Mark;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MarkController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Mark(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('type_id');
            $grid->column('user_id');
            $grid->column('marked_user_id');
            $grid->column('order_id');
            $grid->column('tags');
            $grid->column('satisfy');
            $grid->column('content');
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
        return Show::make($id, new Mark(), function (Show $show) {
            $show->field('id');
            $show->field('type_id');
            $show->field('user_id');
            $show->field('marked_user_id');
            $show->field('order_id');
            $show->field('tags');
            $show->field('satisfy');
            $show->field('content');
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
        return Form::make(new Mark(), function (Form $form) {
            $form->display('id');
            $form->text('type_id');
            $form->text('user_id');
            $form->text('marked_user_id');
            $form->text('order_id');
            $form->text('tags');
            $form->text('satisfy');
            $form->text('content');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
