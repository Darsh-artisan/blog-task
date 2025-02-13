<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->id)
        {
            $rules = 
            [
                'name' => 'required',
                'email' => 'required|email|unique:mysql.users,email,'.decrypt($this->id),
                'confirm_password' =>'same:password',
                'role_id' => 'required',
                'image' => 'mimes:jpeg,png,jpg',
            ];
        }
        else
        {
            $rules = 
            [
                'name' =>  'required',
                'email' =>   'required|email|unique:mysql.users,email',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password|min:6',
                'role_id' => 'required',
                'image' => 'required|mimes:jpeg,png,jpg',
            ];
        }

        return $rules;
    }
}
