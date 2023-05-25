<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\PostImage;
use Inertia\Inertia;
use Auth;
use Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Blogs/Index', [
            'posts' => Post::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($post) => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'body' => $post->body,
                    'images' => $post->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'url' => $image->url,
                        ];
                    }),
                    'can' => [
                        'edit' => Auth::user()->can('edit', $post)
                    ]
                ]),

            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', Post::class)
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store()
    {
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        User::create($attributes);

        return redirect('/users');
    }

    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'images' => $post->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'url' => $image->url,
                    ];
                }),
            ],
        ]);
    }

    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'images' => $post->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'url' => $image->url,
                    ];
                }),
            ],
        ]);
    }

    public function update(Post $post)
    {
        $attributes = Request::validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->update($attributes);

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
