<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasDateTimeFormatter;

    protected $fillable = ['path', 'type', 'detail', 'sort', 'status'];

    // 1 营业执照
    // 2 门店照片


    //图片关联
    public function imagetable()
    {
        return $this->morphTo()->withDefault();
    }
}
