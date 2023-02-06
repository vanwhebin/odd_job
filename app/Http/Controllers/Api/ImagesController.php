<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFile;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImagesController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
            'directory' => 'nullable|string',
        ], [], [
            'image' => '图片',
            'directory' => '目录',
        ]);
        if ($validator->fails()) {
            return $this->failed($validator->errors()->first());
        }
        ini_set('memory_limit', -1);
        set_time_limit(0);
        try {
            $disk = Storage::disk('public');
            $file = $request->image;
            //目录名
            $directory = $request->directory ?? 'images';
            //定义文件名
            $file_name = (auth('api')->user()->id ?? '')  . '_' . date('mdHis') . '_' . rand(0001, 9999) . '.' . $file->getClientOriginalExtension();
            //存储视频或图片
            $file->storeAs(
                "public/".$directory, $file_name
            );
            //获取文件路径
            $file = $disk->url($directory . '/' . $file_name);

            $image = Image::create([
                'path' => $file,
                'type' => $request->image ? 1 : ($request->video ? 2 : 0)
            ]);
        } catch (\Exception $e) {
            dump($e);
            return $this->failed($e->getMessage(), 422);
        }
        //5分钟没有使用即删除该图片
        dispatch(new DeleteFile($image));
        return $this->success([
            'id' =>$image->id,
            'type' =>$image->type,
            'path' =>$image->path,
        ]);
    }

}
