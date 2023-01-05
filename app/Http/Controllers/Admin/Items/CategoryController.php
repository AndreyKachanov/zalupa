<?php

namespace App\Http\Controllers\Admin\Items;

use App\Models\Admin\Item\Category;
use App\Http\Requests\Admin\Items\CreateCategoryRequest;
use App\Http\Requests\Admin\Items\UpdateCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::whereParentId(null)->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function indexSubCategories()
    {
        $subCategories = Category::whereNotNull('parent_id')->orderByDesc('created_at')->paginate(100);
        return view('admin.subcategories.index', compact('subCategories'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    public function createSubCategory()
    {
        $selectCategory = Category::select(['id', 'title'])->whereParentId(null)
            //->whereNull('deleted_at')
            ->orderBy('title')
            ->get();

        $categoriesToView = [];

        foreach ($selectCategory as $category) {
            $categoriesToView[$category->id] = mb_substr($category->title, 0, 60);
        }
        return view('admin.subcategories.create', compact('categoriesToView'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        Category::create([
            'title' => $request->title
        ]);

        return redirect()->route('admin.categories.index');
    }

    public function storeSubCategory(CreateCategoryRequest $request)
    {
        Category::create([
            'title' => $request->title,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('admin.subcategories.index');
    }


    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function showSubCategory(Category $category)
    {
        return view('admin.subcategories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Category $category)
    {

        return view('admin.categories.edit', compact('category'));
    }

    public function editSubCategory(Category $category)
    {
        return view('admin.subcategories.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->only(['title']));
        return redirect()->route('admin.categories.index');
    }

    public function updateSubCategory(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->only(['title']));
        return redirect()->route('admin.subcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index');
    }

    public function destroySubCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.subcategories.index');
    }
}
