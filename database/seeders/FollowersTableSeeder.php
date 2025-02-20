<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        // 获取去除掉 ID 为 1 的所有用户的 ID 数据
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 关注除了 ID 为 1 的用户以外的所有用户
        $user->follow($follower_ids);

        // 除了 ID 为 1 的用户以外的所有用户都来关注 ID 为 1 的用户
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
