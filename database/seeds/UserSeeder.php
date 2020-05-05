<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*\App\User::create([
            'name'=>'lisi',
            'email'=>'lisi@qq.com',
            'password'=>bcrypt('admin888')
        ]);*/
        factory(\App\User::class, 20000)->create();
        $user = \App\User::find(1);
        $user['name'] = '钟晓川';
        $user['email'] = '1028504601@qq.com';
        $user['password'] = bcrypt('123456');
        $user['is_admin'] = 1;
        $user->save();

        $user = App\User::find(2);
        $user['name']='钟淳熙';
        $user['email']='cqzhongxc@hotmail.com';
        $user['password']=bcrypt('123456');
        $user->save();
    }
}
