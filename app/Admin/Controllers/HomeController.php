<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Admin\Repositories\IndexData;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Repositories\EloquentRepository;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('首页')
            ->description('Description...');
//            ->body(function (Row $row) {
//                $row->column(6, function (Column $column) {
//                    $column->row(Dashboard::title());
//                    $column->row(new Examples\Tickets());
//                });
//
//                $row->column(6, function (Column $column) {
//                    $column->row(function (Row $row) {
//                        $row->column(6, new Examples\NewUsers());
//                        $row->column(6, new Examples\NewDevices());
//                    });
//
//                    $column->row(new Examples\Sessions());
//                    $column->row(new Examples\ProductOrders());
//                });
//            });
    }

}
