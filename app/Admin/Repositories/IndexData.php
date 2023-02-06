<?php

namespace App\Admin\Repositories;

use App\Models\Order;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\Repository;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexData extends Repository
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * 定义主键字段名称
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * 查询表格数据
     *
     * @param Grid\Model $model
     * @return LengthAwarePaginator
     */
    public function get(Grid\Model $model)
    {
        $admin_id = Admin::user()->id;

        //如果查看时间包含今天，需从订单表中取数据，
        return Order::where('status', 1)
            ->when(Admin::user()->isRole('first_agent'), function ($query) use ($admin_id) {
                return $query->whereHasIn('user', function ($query) use ($admin_id) {
                    return $query->agentId($admin_id);
                });
            })
            ->with([
                'user',
                'user.agent',
                'good',
            ])
            ->get()
            ->map(function ($order) {
                $user = $order->user;
                return [
                    'user_id' => $order->user_id,
                    'user_name' => $user->name,
                    'agent_id' => $user->agent->id,
                    'agent_name' => $user->agent->name,
                    'good_name' => $order->good->name,
                    'type' => $order->type,
                    'price' => $order->price,
                    'paid_at' => optional($order->paid_at)->toDateTimeString(),
                ];
            });
    }
}
