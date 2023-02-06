<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
	use HasDateTimeFormatter;
    protected $fillable = [
        'real_name',
        'ID_card_no',
        'name',
        'type',
        'address',
        'province',
        'province_id',
        'city',
        'city_id',
        'area',
        'area_id',
        'phone',
        'user_id',
        'wallet',
        'status',
    ];

    protected $casts = [
        'extra' => 'array',
    ];

    //营业执照
    public function certImage()
    {
        return $this->morphOne('App\Models\Image', 'imagetable')->where('detail', 1);
    }
    //门店照片
    public function shopImage()
    {
        return $this->morphOne('App\Models\Image', 'imagetable')->where('detail', 2);
    }
    //状态  0 待审核 1 正常 2 驳回
    public function getShopStatusAttribute()
    {
        if ($this->status == 0) {
            $msg = '已提交注册信息，请等待审核';
        } elseif ($this->status == 1) {
            $msg = '注册正常';
        } elseif ($this->status == 2) {
            $msg = $this->extra['mark']??'审核被驳回';
        }else{
            $msg = '其它';
        }
        return [
            'status' => $this->status,
            'msg' => $msg,
        ];
    }

    //店长
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //关联的店铺
    public function relateShops()
    {
        return $this->hasMany(Shop::class,'relate_id');
    }
    //总部帐户
    public function parentShop()
    {
        return $this->belongsTo(Shop::class,'relate_id');
    }
}
