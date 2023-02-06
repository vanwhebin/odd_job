<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\BaseResource;

class OrderResource extends BaseResource
{
    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'shop'=>$this->shop->name,
            'position'=>$this->position->name,
            'position_id'=>$this->position_id,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'urgent'=>$this->urgent,
            'amount'=>$this->amount,
            'wage'=>$this->wage,
            'total'=>$this->total,
            'status'=>$this->status,


            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ]);
    }
}
