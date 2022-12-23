<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{

    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });

        $categoriesQuery = QueryBuilder::for(Category::withTrashed())
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->allowedFilters(['name', $globalSearch])
            ->paginate()
            ->withQueryString();

        $categories = SpladeTable::for($categoriesQuery)
            ->defaultSort('name')->withGlobalSearch()
            ->column('name', sortable: true, searchable: true, canBeHidden: false)
            ->column('slug')
            ->column('status')
            ->column('action');

        return view('admin/category/index', [
            'categories' => $categories
        ]);
    }


    public function create()
    {
        return view('admin/category/create');
    }


    public function store(StoreCategoryRequest $request)
    {

        $category = Category::create($request->all());

        Toast::title('Your Category ' . $category['name'] . ' was created!')->autoDismiss(5);

        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        return view('admin/category/show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin/category/edit', [
            'category' => $category
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        Toast::title('Your Category ' . $category['name'] . ' was updated!')->info()->autoDismiss(5);

        return redirect()->route('admin.categories.index');
    }


    public function destroy(Category $category)
    {
        $category->delete();

        Toast::title('Your Category  was deleted!')->danger()->autoDismiss(5);

        return redirect()->back();
    }

    public function restore(Category $category)
    {

        $category->restore();

        Toast::title('Your Category  was restore!')->info()->autoDismiss(5);

        return redirect()->route('admin.categories.index');
    }

    public function force_delete(Category $category)
    {
        $category->forceDelete();

        Toast::title('Your Category  was permanently deleted!')->danger()->autoDismiss(5);

        return redirect()->route('admin.categories.index');
    }
}
