<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasDateTimeFormatter;

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }
}
