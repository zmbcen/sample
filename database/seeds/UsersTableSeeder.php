<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password','remember_token'])->toArray());

        $user = User::find(1);
        $user->name = '周沐柏岑';
        $user->email = 'zmbcen@163.com';
        $user->password = bcrypt('zmbcen19980826');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
