<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Position;
use App\Models\Trade;
use App\Models\Type;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PositionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Position(['trade']), function (Grid $grid) {
            //排序
            $grid->model()->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('trade.name','行业');
            $grid->column('content')->limit(20);
            $grid->column('wage');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

//            $grid->filter(function (Grid\Filter $filter) {
//                $filter->equal('id');
//
//            });
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
        return Form::make(new Position(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->select('trade_id')
                ->options(Trade::get()->pluck('name', 'id'));
            $form->textarea('content');
            $form->currency('wage')->symbol('￥');
            $form->distpicker(['province_id', 'city_id', 'area_id'])->autoselect(3)->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
