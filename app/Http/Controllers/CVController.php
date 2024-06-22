<?php

namespace App\Http\Controllers;

use App\Http\Requests\CV\StoreRequest;
use App\Models\CV;
use App\Http\Services\CV\Service;
use Illuminate\Http\Request;

class CVController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        $this->authorize('create', CV::class);
        return view('cv.create');
    }
    public function store(StoreRequest $request)
    {
        $this->authorize('create', CV::class);
        $data = $request->validated();
        $this->service->store($data, auth()->user());

        return redirect()->route('profile')->with('success', 'Резюме отправлено');
    }
}
