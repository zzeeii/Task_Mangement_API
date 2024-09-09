<?php

namespace App\Http\Requests;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        
       /* $user_id = $this->route('id');
        $usere = User::find($user_id);
        if (!$usere) {
            return false;
        }
      echo $user_id;
      echo $usere;*/
        return Auth::user()->role === 'admin' || Auth::id() === $this->user->id;
        
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|nullable|email|unique:users,email,',
            'role' => 'sometimes|nullable|in:admin,manager,user',
        ];
    }
}
