<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'full_name' => 'required|min:3|max:255',
            'role' => 'required',
        ];
        if (!empty($this->input('id'))) {

//            if (!empty($this->input('password'))) {
//                $rules['password'] = 'required|min:6|max:255';
//            }
            $rules['email'] = 'required|email|unique:users,email,' . $this->input('id');
            $rules['phone'] = 'required|unique:users,phone,' . $this->input('id');
        } else {
//            $rules['password'] = 'required|min:6|max:255';
            $rules['password'] = 'required|min:6';
            $rules['email']    = 'required|max:255|email|unique:users,email';
            $rules['phone']    = 'required|unique:users,phone';
        }
        return $rules;
    }
}
