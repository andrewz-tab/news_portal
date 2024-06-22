<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Post\Service;
use App\Models\Post;
use App\Http\Requests\Post\FilterRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('admin_panel.post.create');
    }
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('admin_panel.post.edit', compact('post'));
    }
    public function index(FilterRequest $request)
    {
        $data = $request->validated();
        $search = isset($data['search']) ? $data['search'] : '';
        $posts = $this->service->adminIndex($data);
        return view('admin_panel.post.index', compact('posts', 'search'));
    }
    public function show($post)
    {
        $post = $this->service->adminShow($post);
        return view('admin_panel.post.show', compact('post'));
    }
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Post::class);
        $data = $request->validated();
        $this->service->store($data, auth()->user());
        return redirect()->route('admin.posts.index')->with('success', 'Новость успешно создана');
    }
    public function update(UpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validated();
        $this->service->update($post, $data);
        return redirect()->route('admin.posts.index')->with('success', 'Новость успешно обновлена');
    }
}
