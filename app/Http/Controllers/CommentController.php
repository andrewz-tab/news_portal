<?php

namespace App\Http\Controllers;

use App\Http\Services\Comment\Service;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    
    public function store(StoreRequest $request, Post $post)
    {
        $this->authorize('create', Comment::class);
        $data = $request->validated();
        $this->service->store($data, $post, auth()->user());

        return redirect()->route('posts.show', $post->id);
    }
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comment.edit', compact('comment'));
    }
    public function update(UpdateRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $data = $request->validated();
        $this->service->update($comment, $data);
        return redirect()->route('posts.show', $comment->post->id);
    }
    public function restore(int $commentId)
    {
        $comment = Comment::withTrashed()->find($commentId);
        if ($comment == null) {
            abort(404);
        }
        $this->authorize('restore', $comment);
        if ($this->service->restore($comment)) {
            return redirect()->back()->with('success', 'Комментарий успешно востановлен');
        } else {
            return redirect()->back()->with('error', 'Комментарий уже был востановлен');
        }
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $post_id = $comment->post_id;
        $comment->delete();
        return redirect()->back()->with('success', 'Комментарий удален');
    }

}
