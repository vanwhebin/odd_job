<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeleteFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $image;

    public function __construct($image, $time = null)
    {
        $this->image = $image;
        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        if ($time) {
            $this->delay($time);
        } else {
            $this->delay(now()->addSeconds(30));
//            $this->delay(now()->addMinutes(20));
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->image->refresh();
        if (!$this->image) {
            return;
        }
        if (is_string($this->image)) {
            //传的url
            $image = Image::where('path', $this->image)
//                ->orWhere('path', $this->image . '?imageView2/0/w/200/h/200')
                ->first();
            if (!$image) {
                $file = Str::after(Str::before($this->image, '?'), 'com/');
//                $file = Str::after(Str::before($this->image, '?'), 'storage/');
                //删除
                Storage::disk('public')->delete($file);
                return;
            }
            $this->image = $image;
        }
        Log::channel('error')->debug('现在的图片是'. $this->image);
        if (is_array($this->image)) {
            foreach ($this->image as $image) {
                if (!$image->detail && !$image->imagetable_id) {
                    //获取图片在七牛的路径
                    $path = $image->path;
                    $file = Str::after(Str::before($path, '?'), 'com/');
                    //删除
                    Storage::disk('public')->delete($file);
                    //路径
//                    $path = Str::before($path, '?imageView2/0/w/200/h/200');
                    $image->delete();
                }
            }
        } elseif (!$this->image->detail || !$this->image->imagetable_id) {
            Log::channel('error')->debug('图片没有被使用才可以删除'. $this->image);
            //图片没有被使用才可以删除
            //获取图片在七牛的路径
            $path = $this->image->path;
//            $file = Str::after(Str::before($path, '?'), 'com/');
            $file = Str::after(Str::before($path, '?'), 'storage/');
            //删除
            Storage::disk('public')->delete($file);
            //路径
//            $path = Str::before($this->image->path, '?imageView2/0/w/200/h/200');
            try {
                $this->image->delete();
            } catch (\Exception $exception) {
                dump($exception->getMessage());
            }
        }
    }
}
