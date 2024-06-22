<?php

namespace App\Http\Controllers;

use App\Http\Services\Profile\Service;
use App\Http\Requests\Profile\UpdateGeneralRequest;

use App\Http\Requests\Post\FilterRequest;
use App\Models\User;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function favourites()
    {
        $user = auth()->user();
        $posts = $this->service->getFavourites($user);
        return view('profile.favourites', compact('posts'));
    }
    public function index()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }
    public function news(FilterRequest $request)
    {
        $data = $request->validated();
        $posts = $this->service->getPosts($data, auth()->user());
        return view('profile.news', compact('posts'));
    }
    public function settings()
    {
        $user = auth()->user();
        return view('profile.settings', compact('user'));
    }
    public function subscriptions()
    {
        $user = auth()->user();
        $subscriptions = $this->service->getSubscription($user);
        return view('profile.subscriptions', compact('subscriptions'));
    }
    public function update_general(UpdateGeneralRequest $request)
    {
        $data = $request->validated();
        $this->service->updateGeneral($data, auth()->user());
        User::whereId(auth()->user()->id)->update($data);
        return redirect()->back()->with("statusG", "Данные успешно изменены!");
    }
    public function update_password(UpdatePasswordRequest $request)
    {
        $data = $request->validated();
        $response = $this->service->updatePassword($data, auth()->user());
        
        return redirect()->back()->with($response[0], $response[1]);
    }
}
