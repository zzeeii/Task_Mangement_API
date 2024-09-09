<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class UserService
{
    public function updateUser( $id, array $data)
    {
        $user=User::find($id);
      
        if (Auth::user()->role !== 'admin' && Auth::id() !== $user->id) {
            throw new UnauthorizedException('Unauthorized to update user');
        }

       
        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user=User::find($id);
       
        if (Auth::user()->role !== 'admin') {
            throw new UnauthorizedException('Only admin can delete users');
        }

        $user->delete();
    }
}
