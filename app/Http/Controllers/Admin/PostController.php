<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{

    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('title', 'LIKE', "%{$value}%");
                });
            });
        });

        $postsQuery = QueryBuilder::for(Post::class)
            ->defaultSort('title')
            ->allowedSorts(['title', 'category.name'])
            ->allowedFilters(['title', 'category.name', $globalSearch])
            ->paginate()
            ->withQueryString();

        $posts = SpladeTable::for($postsQuery)
            ->defaultSort('title')->withGlobalSearch()
            ->column('title', sortable: true, searchable: true, canBeHidden: false)
            ->column('category.name', sortable: true, searchable: true, canBeHidden: false)
            ->column('thumbnail')
            ->column('action')
            ->rowLink(function (Post $post) {
                return route('admin.posts.show', $post->slug);
            });
        return view('admin/post/index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('admin/post/create', [
            'categories' => Category::get()
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->all());
        if ($request->file('thumbnail')) {
            $path =  $request->file('thumbnail')->store('posts', 'public');
            $post->thumbnail = $path ?? null;
            $post->save();
        }
        Toast::title('Your Post ' . $post['title'] . ' was created!')->autoDismiss(5);

        return redirect()->route('admin.posts.index');
    }

    public function show(Post $post)
    {
        return view('admin/post/show', [
            'post' => $post
        ]);
    }

    public function edit(Post $post)
    {
        return view('admin/post/edit', [
            'categories' => Category::get(),
            'post' => $post
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());
        if ($request->file('thumbnail') !== null) {
            $path = $request->file('thumbnail')->store('posts', 'public');
            if ($path) Storage::disk('public')->delete($post->thumbnail);
            $post->thumbnail = $path ?? null;
            $post->save();
        }
        Toast::title('Your Post ' . $post['title'] . ' was updated!')->info()->autoDismiss(5);

        return redirect()->route('admin.posts.index');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        $post->delete();
        Toast::title('Your Post  was deleted!')->danger()->autoDismiss(5);
        return redirect()->back();
    }
}
