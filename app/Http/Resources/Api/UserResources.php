<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\BaseResource;

class UserResources extends BaseResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'subscribe' => $this->subscribe,
            'phone' => $this->phone,
            'sex' => $this->sex,
            'age' => $this->age,
            'birthday' => $this->birthday,
            'status' => $this->status,
            'user_status' => $this->user_status,
            'shop' => $this->shop->status??null,

            'complete' => $this->complete,
            'last_actived_at' => optional($this->last_actived_at)->toDateTimeString(),
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->last_actived_at)->toDateTimeString(),
        ];

        return $this->filterFields($data);
    }
}
