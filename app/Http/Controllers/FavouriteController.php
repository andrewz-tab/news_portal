<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Favourite\Service;
use App\Models\Favourite;
use App\Models\Post;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function store(Post $post)
    {
        $this->authorize('create', Favourite::class);
        $this->service->store(auth()->user(), $post);
        return redirect()->back();
    }
}
