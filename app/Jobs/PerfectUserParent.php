<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerfectUserParent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->delay(now()->addSeconds(5));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        Log::channel('error')->info('修复用户上次 用户 ID==' . $this->user->id);
//        //修复用户上级closure
        $this->user->perfectNode();
//        dispatch(new CreateNotice($this->user,1));
//        //上级
//        if ($this->user->parent_id) {
//            $parent = $this->user->parent;
//            //邀请好友注册成功
//            dispatch(new CreateNotice($parent,2));
//
//        }
    }
}
