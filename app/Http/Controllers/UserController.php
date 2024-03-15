<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    protected UserRepository $userRepository;
    public function __construct()
    {
        $this->user = new User();
        $this->userRepository = new UserRepository();   

    }
    public function index()
    {
        $users = $this->userRepository->getAllForMembers();
        return $users;

    }

    public function store(UserRequest $request)
    {
        $userCreate = $this->userRepository->createUser($request);
        event(new \App\Events\Myevent("User created"));
        return $userCreate;
    }

    public function show(string $id)
    {
        return $user = $this->user->find($id);
    }
    public function update(Request $request, string $id)
    {
        $user = $this->user->find($id);
        $user->update($request->all());
        event(new \App\Events\UpdateEvent());
        return $user;
    }   
    public function destroy(string $id)
    {
        $user = $this->user->find($id);
        $deleted = $user->delete();
        event(new \App\Events\DeleteEvent());
        return $deleted;
    }
}