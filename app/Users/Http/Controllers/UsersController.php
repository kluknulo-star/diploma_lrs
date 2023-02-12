<?php

namespace App\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Users\Models\Token;
use App\Users\Requests\CreateUserRequest;
use App\Users\Requests\UpdateUserRequest;
use App\Users\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function __construct(protected UserService $userService)
    {
    }

    public function index(): View
    {
        $users = $this->userService->getUsers();
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function store(CreateUserRequest $request): View
    {
        $validatedUserData = $request->validated();
        $user = $this->userService->createNewUser($validatedUserData);

        return view('users.show', [
            'user' => $user
        ]);
    }

    public function show(Request $request, int $userId): View
    {
        $user = $this->userService->getUserById($userId);
        return view('users.show', [
            'user' => $user
        ]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function update(UpdateUserRequest $request, User $id): RedirectResponse
    {
        $validatedUserData = $request->validated();
        $this->userService->updateUser($id, $validatedUserData);
        return redirect()->route('users.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $deletedUser = (int)$request->id;

        if (Auth::id() !== $deletedUser) {
            User::destroy($deletedUser);
        }
        return redirect()->route('users.index');
    }

    public function edit(User $id): View
    {
        return view('users.edit', [
            'user' => $id
        ]);
    }

    public function profile(): View
    {
        $tokens = $this->userService->getUserTokens();
        return view('users.profile', [
            'tokens' => $tokens,
        ]);
    }

    public function generateUserToken(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token_live_time' => 'required|min:1|max:30|integer'
        ]);

        $this->userService->generateUserToken($validated['token_live_time']);
        return redirect()->route('profile', [
            'tokens' => $this->userService->getUserTokens()
        ]);
    }

    public function deleteToken(Token $token): RedirectResponse
    {
        $token->delete();
        return redirect()->route('profile');
    }
}
