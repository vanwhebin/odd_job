<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Area;
use App\Jobs\CloseTopWork;
use App\Jobs\CreateNotice;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SuperEggs\DcatDistpicker\DcatDistpickerHelper;

class AreaController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Area(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('province_id')->distpicker();
            $grid->column('city_id')->distpicker();
            $grid->column('area_id')->distpicker();
            $grid->column('price');
            $grid->column('status')->switch();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
            $grid->disableViewButton();
            $grid->disableBatchActions();
        });
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Area(), function (Form $form) {
            $form->display('id');
            $form->distpicker(['province_id', 'city_id', 'area_id'])->autoselect(3)->required();
            $form->currency('price')->symbol('￥');
            $form->switch('status')->default(1);
            $form->display('created_at');
            $form->display('updated_at');
            $form->hidden('province');
            $form->hidden('city');
            $form->hidden('area');

            $form->saving(function (Form $form) {

                //修改地址
                if ($form->province_id) {
                    $province = DcatDistpickerHelper::getAreaName($form->province_id);
                    $city = DcatDistpickerHelper::getAreaName($form->city_id);
                    $area = DcatDistpickerHelper::getAreaName($form->area_id);
                    $form->province=$province;
                    $form->city=$city;
                    $form->area=$area;
                }
            });
        });
    }
}
