<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class NewUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to create new user in the database ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user['name'] = $this->ask('enter user name ? ');
        $user['email'] = $this->ask('enter user email ? ');
        $user['password'] = $this->secret('enter user password ? ');


        $roleName = $this->choice('enter the role of the user ? ' , ['admin' , 'editor'] , 'editor' , 2);
        $role = Role::where('name' , $roleName)->first();
        if(!$role)
        {
            $this->error('there is no role ' . $roleName . ' in the database');
            return -1;
        }

        $validator = Validator::make($user , [
            'name' => ['required' , 'min:3' , 'max:255' , 'string'] ,
            'email' => ['required' , 'email' , 'string' , Rule::unique('users' , 'email')] ,
            'password' => [Password::default() , 'required'] ,
        ]);

        if($validator->fails()){
            foreach($validator->errors()->all() as $error){
                $this->error($error);
            }
            return -1;
        }

        DB::transaction(function () use ($user , $role) {
            $user['password'] = Hash::make($user['password']) ;
            $newUser = User::create($user);
            $newUser->roles()->attach($role->id);
        });

        $this->info('the ' . $roleName . ' ' . $user['name'] . ' created successfully :)');
    }
}
