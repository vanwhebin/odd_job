<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\BaseResource;

class PositionResource extends BaseResource
{
    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'name' => $this->name,
            'trade_id' => $this->trade_id,
            'trade' => $this->trade->name,
            'content' => $this->content,
            'wage' => $this->wage,
            'low_price' => $this->withData??'',
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ]);
    }
}
