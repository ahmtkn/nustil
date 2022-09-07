<?php

namespace App\Http\Controllers\Dashboard\Blog;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\ProductController;

class PostController extends Controller
{

    public function filtered(string $filter = null)
    {
        $modal = BlogPost::with('categories');
        $filter = $filter ?? 'all';
        switch ($filter) {
            case "trashed":
                $posts = $modal->onlyTrashed()->latest()->paginate(10);
                break;
            case "published":
                $posts = $modal->published()->latest()->paginate(10);
                break;
            case "draft":
                $posts = $modal->onlyDraft()->latest()->paginate(10);
                break;
            case "all":
                $posts = $modal->latest()->paginate(10);
                break;
        }
        $counts = (object)[
            'all' => BlogPost::count(),
            'published' => BlogPost::published()->count(),
            'draft' => BlogPost::onlyDraft()->count(),
            'trashed' => BlogPost::onlyTrashed()->count(),
        ];

        return view('dashboard.blog.posts.index', compact('posts', 'counts', 'filter'));
    }

    public function create()
    {
        return view(
            'dashboard.blog.posts.editor',
            [
                'post' => new BlogPost(),
                'categories' => BlogCategory::with('descendants')->get(),
            ]
        );
    }

    public function store(BlogPostCreateRequest $request)
    {
        $published_at = $request->validated('status') == 'published'
            ? ['published_at' => now()]
            : [];
        $post = BlogPost::create($request->validated() + $published_at);

        if ($request->hasFile('image')) {
            $image = MediaController::uploadImage($request, 'image', ['type' => 'post-thumbnail']);
            $post->image()->save($image);
        }


        $post->categories()->attach($request->validated('categories'));
        cache()->flush();

        return redirect()->route('dashboard.blog.posts.index')->with('message', 'Post created successfully');
    }

    public function edit(BlogPost $post)
    {
        $post->load('categories', 'image');

        return view(
            'dashboard.blog.posts.editor',
            [
                'post' => $post,
                'categories' => BlogCategory::with('descendants')->get(),
            ]
        );
    }

    public function update(BlogPostUpdateRequest $request, BlogPost $post)
    {
        if ($post->image()->exists() && $request->hasFile('image')) {
            $post->image()->delete();
            $image = MediaController::uploadImage($request, 'image', ['type' => 'post-thumbnail']);
            $post->image()->save($image);
        }
        $published_at = $request->validated('status') == 'published' && $post->published_at == null
            ? ['published_at' => now()]
            : [];
        $post->update($request->validated() + $published_at);
        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }
        cache()->flush();

        return redirect()->route('dashboard.blog.posts.index')->with('message', 'Post updated successfully');
    }

    public function delete(BlogPost $post)
    {
        $post->status = 'trashed';
        $post->save();
        if ($post->trashed()) {
            $message = 'Post is permanently deleted';
            $post->forceDelete();
        } else {
            $message = 'Post is deleted';
            $post->delete();
        }
        cache()->flush();

        return redirect()->route('dashboard.blog.posts.index')->with('message', $message.' successfully');
    }

    public static function detectKeywords(string $text): string
    {
        $text = strip_tags(Str::markdown($text));

        Str::replace($text, "\n", " ");

        $keywords = [];

        collect(array_count_values(explode(' ', $text)))->filter(function ($count, $word) {
            return $count > 2;
        })->each(function ($count, $word) use (&$keywords) {
            $keywords[] = $word;
        });


        return implode(',', $keywords);
    }

}
