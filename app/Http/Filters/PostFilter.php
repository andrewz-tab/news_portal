<?php

namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class PostFilter extends AbstractFilter
{
    public const TITLE = 'title';
    public const CONTENT = 'content';
    public const AUTHOR_ID = 'author_id';
    public const SEARCH = 'search';

    protected function getCallbacks(): array
    {
        return [
            self::AUTHOR_ID => [$this, 'auhtorId'],
            self::TITLE => [$this, 'title'],
            self::CONTENT => [$this, 'content'],
            self::SEARCH => [$this, 'search'],
        ];
    }
    public function search(Builder $builder, $value)
    {
        $builder->where('title', 'like', "%{$value}%", 'or')
            ->orWhere('content', 'like', "%{$value}%");
    }
    public function title(Builder $builder, $value)
    {
        $builder->where('title', 'like', "%{$value}%",);
    }
    public function content(Builder $builder, $value)
    {
        $builder->where('content', 'like', "%{$value}%");
    }
    public function auhtorId(Builder $builder, $value)
    {
        $builder->where('author_id', value: "%{$value}%");
    }
}
