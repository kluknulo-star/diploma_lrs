<?php

namespace App\Users\Services;

use App\Models\User;
use App\Users\Models\Token;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function getUsers(): CursorPaginator
    {
        return User::query()->cursorPaginate(7);
    }

    public function getUserById(int $id): Model
    {
        return User::query()->findOrFail($id);
    }

    public function createNewUser(array $userAttributes): User
    {
        $user = new User();
        $user->name = $userAttributes['name'];
        $user->email = $userAttributes['email'];
        $user->password = $userAttributes['password'];
        $user->save();
        return $user;
    }

    public function updateUser(User $user, array $attributesForUpdating): bool
    {
        return $user->update($attributesForUpdating);
    }

    public function generateUserToken(int $daysQuantity): ?Token
    {
        if (auth()->user()->userTokens()->count() >= 6) {
            return null;
        }
        $token = new Token();
        $token->token = Hash::make(rand(0, 999999));
        $token->user_id = Auth::user()->user_id;
        $token->expiration_date = now()->addDays($daysQuantity)->roundDay();
        $token->save();
        return $token;
    }

    public function getUserTokens(): Collection
    {
        return Auth::user()->userTokens()->get();
    }
}
