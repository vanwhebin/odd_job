<?php
/**
 * Created by PhpStorm.
 * User: Jourdon
 * Date: 2019-08-07
 * Time: 13:47
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    protected $withoutFields = [];
    protected $hide = true;


    public function hide(array $fields)
    {
        $this->withoutFields = $fields;

        return $this;
    }

    public function show(array $fields)
    {
        $this->withoutFields = $fields;
        $this->hide = false;

        return $this;
    }

    protected function filterFields($array)
    {
        if (!$this->hide) {
            return collect($array)->only($this->withoutFields)->toArray();
        }

        return collect($array)->forget($this->withoutFields)->toArray();
    }

}
