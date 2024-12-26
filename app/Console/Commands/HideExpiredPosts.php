<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;

class HideExpiredPosts extends Command
{
    protected $signature = 'posts:hide-expired';
    protected $description = 'Ẩn các bài đăng hết hạn đăng bài';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy các bài đăng hết hạn đăng bài
        $expiredPosts = Job::where('Hide', false)
            ->where('post_expires_at', '<', Carbon::now()) // Hết hạn đăng bài
            ->get();

        foreach ($expiredPosts as $post) {
            $post->Hide = true; // Cập nhật trạng thái ẩn
            $post->save();
            $this->info("Bài đăng với ID {$post->id} đã hết hạn và được ẩn.");
        }

        $this->info("Hoàn thành kiểm tra các bài đăng hết hạn.");
    }
}
