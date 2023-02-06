<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PositionResourceCollection;
use App\Http\Resources\Api\ShopResource;
use App\Models\Area;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request  $request)
    {
        if($request->area_id){
            $price=Area::where('area_id',$request->area_id)->first()->price;
        }
        $positions = Position::with('trade')->get();
        return PositionResourceCollection::make($positions,$price??null)->additional([
            'code' => 200,
            'status' => "success",
            'first_price' => config('services.first_hour_price'),
            'second_price' => config('services.second_hour_price'),
            'third_price' => config('services.third_hour_price'),
        ]);
    }
}
