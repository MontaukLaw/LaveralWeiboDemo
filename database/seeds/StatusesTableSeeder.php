<?php
/**
 * Created by PhpStorm.
 * User: Marc LAW: zunly@hotmail.com
 * Date: 2018/12/26
 * Time: 22:26
 */

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    //用Fake产生100条数据
    public function run()
    {
        $user_ids = ['1', '2', '3'];
        $faker = app(Faker\Generator::class);

        $statuses = factory(Status::class)->times(100)->make()->each(function ($status) use ($faker, $user_ids) {
            $status->user_id = $faker->randomElement($user_ids);
        });

        Status::insert($statuses->toArray());
    }
}