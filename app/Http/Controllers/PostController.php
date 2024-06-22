<?php

namespace App\Http\Controllers;

use App\Http\Services\Post\Service;
use App\Models\Post;
use App\Http\Requests\Post\FilterRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use Illuminate\Support\Facades\DB;
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
        return view('post.create');
    }
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $start = microtime(true);
        $post->delete();
        dump(round(microtime(true) - $start, 4).' сек.');
        return redirect()->back()->with('success', 'Новость удалена');
    }
    public function edit(Post $post)
    {
        $start = microtime(true);
        $post = Post::find($post->id);
        dump(round(microtime(true) - $start, 4).' сек.');
        $start = microtime(true);
        DB::select('select * from posts where id = ? and deleted_at is null limit 1', [$post->id]);
        dump(round(microtime(true) - $start, 4).' сек.');
        $this->authorize('update', $post);
        return view('post.edit', compact('post'));
    }
    public function index(FilterRequest $request)
    {
        $data = $request->validated();
        $search = isset($data['search'])? $data['search'] : '';
        $posts = $this->service->index($data);
        return view('post.index', compact('posts', 'search'));
    }
    public function restore(int $postId)
    {
        $post = Post::withTrashed()->find($postId);
        if($post == null) {
            abort(404);
        }
        $this->authorize('restore', $post);
        if ($this->service->resotore($post)) {
            return redirect()->back()->with('success', 'Новость успешно востановлена');
        } else {
            return redirect()->back()->with('error', 'Новость уже была востановлена');
        }  
    }
    public function show($post)
    {
        $post = $this->service->show($post);
        return view('post.show', compact('post'));
    }
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Post::class);
        $data = $request->validated();
        $this->service->store($data, auth()->user());
        return redirect()->route('posts.index');
    }
    public function update(UpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validated();
        $this->service->update($post, $data);
        return redirect()->route('posts.show', $post->id);
    }

}
