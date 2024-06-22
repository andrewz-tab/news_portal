<?php

namespace App\Http\Controllers;

use App\Http\Services\Subscription\Service;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function store(User $author)
    {
        $this->authorize('create', Subscription::class);
        $this->service->store(auth()->user(), $author);
        return redirect()->back();
    }
}
