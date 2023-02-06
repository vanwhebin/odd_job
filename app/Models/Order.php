<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasDateTimeFormatter;

    protected $fillable = [
        'user_id',
        'no',
        'shop_id',
        'position_id',
        'start_date',
        'end_date',
        'day_range',
        'start_time',
        'end_time',
        'urgent',
        'amount',
        'wage',
        'meal',//meal
        'sex',
        'age',
        'content',
        'total',
        'paid_at',
        'status',
        'extra',
    ];

    protected $casts = [
        'day_range' => 'array',
        'extra' => 'array',
    ];

    //订单状态  0待付款 1 已付款 2 已完成 3 已取消

    //流水号
    public static function findAvailableNo($flag = 'order')
    {
        // 订单流水号前缀
        /****** 6  打头为付款订单*****/
        //  61付款

        //  71 充值
        switch ($flag) {
            case 'order'://付款
                $prefix = 61;
                break;
            case 'store'://充值
                $prefix = 71;
                break;
            default:
                $prefix = $flag;
                break;
        }
        do {
            // Uuid类可以用来生成大概率不重复的字符串
            $no = $prefix . date('ymdHis') . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            // 为了避免重复我们在生成之后在数据库中查询看看是否已经存在相同的退款订单号
        } while (self::query()->where('no', $no)->exists());

        return $no;
    }
    //店长，订单发布者
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //发布门店
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    //发布职位
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
