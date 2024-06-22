<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Comment\Service;
use App\Models\Comment;
use App\Http\Requests\Comment\UpdateRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('admin_panel.comment.edit', compact('comment'));
    }
    public function index()
    {
        $comments = Comment::withTrashed()->orderByDesc('created_at')->paginate(10);
        return view('admin_panel.comment.index', compact('comments'));
    }
    public function update(UpdateRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $data = $request->validated();
        $this->service->update($comment, $data);
        return redirect()->route('admin.comments.index')->with('success', 'Комментарий успешно обновлен');
    }
}
