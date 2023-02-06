<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\BaseResource;
use App\Models\Area;

class ShopResource extends BaseResource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->id,
            'name' => $this->real_name.'的店 - '.$this->shop_name,
            'shop_name' => $this->shop_name,
            'real_name' => $this->real_name,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
        if (request()->routeIs('shops.index')) {
            $area = Area::where('area_id', $this->area_id)->first();
            $data['low_price'] = $area->price ?? config('services.low_price');
        }
        if (request()->routeIs('shops.show')) {
            $data['cert'] = $this->certImage;
            $data['shop'] = $this->shopImage;
            $data['ID_card_no'] = $this->ID_card_no;
            $data['type'] = $this->type;
            $data['province'] = $this->province;
            $data['province_id'] = $this->province_id;
            $data['city'] = $this->city;
            $data['city_id'] = $this->city_id;
            $data['area'] = $this->area;
            $data['area_id'] = $this->area_id;
            $data['address'] = $this->address;
            $data['phone'] = $this->phone;
            $data['shop_status'] = $this->shop_status;
            $data['reject'] = $this->extra['reject'] ?? '';
        }
        return $this->filterFields($data);
    }
}
