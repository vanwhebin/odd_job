<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(['agent']), function (Grid $grid) {
            //排序
            $grid->model()->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('uuid');
            $grid->column('agent','上级代理')->display(function(){
                if(!$this->agent){
                    return '';
                }
                return $this->agent->name."<br>".$this->agent_id;
            });
            $grid->column('name');
            $grid->column('phone');
            $grid->column('avatar')->image(100,100);
//            $grid->column('subscribe')->switch();
//            $grid->column('status')->switch();
            $grid->column('last_actived_at');
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
            $grid->disableActions();
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->display('uuid');
            $form->text('name');
            $form->text('phone');
//            $form->switch('subscribe');
//            $form->switch('status');
            $form->text('last_actived_at');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
