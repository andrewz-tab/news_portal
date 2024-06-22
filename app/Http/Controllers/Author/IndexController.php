<?php

namespace App\Http\Controllers\Author;

class IndexController
{
    public function __invoke()
    {
        $author = auth()->user();
        return view('author_panel.index', compact('author'));
    }
}
