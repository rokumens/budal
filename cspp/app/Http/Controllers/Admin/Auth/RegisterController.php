<?php
namespace App\Http\Controllers\Admin\Auth;

use Backpack\CRUD\app\Http\Controllers\Auth\RegisterController as BackpackRegisterController;
use Validator;

class RegisterController extends BackpackRegisterController 
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $users_table = $user->getTable();
        $email_validation = backpack_authentication_column() == 'email' ? 'email|' : '';

        $messages = array('email.regex' => 'Can accept only "@asiapowergames.com" email type.');

        return Validator::make($data, [
            'name'                             => 'required|max:255|unique:'.$users_table,
            backpack_authentication_column()   => 'required|'.$email_validation.'max:255|regex:/(.*)@asiapowergames\.com/i|unique:'.$users_table,
            'password'                         => 'required|min:6|confirmed',
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $nik = substr($data['email'], 0, 4);

        return $user->create([
            'name'                             => $data['name'],
            'nik'                              => $nik,
            backpack_authentication_column()   => $data[backpack_authentication_column()],
            'password'                         => bcrypt($data['password']),
        ]);
    }
}