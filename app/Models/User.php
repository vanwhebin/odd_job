<?php

namespace App\Models;

use App\Models\Traits\LastActivedAtHelper;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Jiaxincui\ClosureTable\Traits\ClosureTable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Vinkla\Hashids\Facades\Hashids;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,HasDateTimeFormatter,LastActivedAtHelper,ClosureTable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agent_id',
        'name',
        'phone',
        'weapp_openid',
        'weixin_openid',
        'weixin_unionid',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $parentColumn = 'parent_id';

    protected static function boot()
    {
        parent::boot();
        // 监听模型查询事件，在读取数据库之后触发
        static::retrieved(function ($model) {
//            if (empty($model->name)) {
//                $model->name = '昵称_' . date('ymdHi');
//                $model->timestamps = false;
//                $model->save();
//            }
            if (empty($model->uuid) && $model->id) {
                $model->uuid = Hashids::encode($model->id);
                $model->timestamps = false;
                $model->save();
            }
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    //用户的上级
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
    //用户的下级
    public function children()
    {
        return $this->hasMany(get_class($this), 'parent_id');
    }

    //用户的店铺
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }
}
