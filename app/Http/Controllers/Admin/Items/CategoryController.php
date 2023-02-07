<?php

namespace App\Http\Controllers\Admin\Items;

use App\Models\Admin\Item\Category;
use App\Http\Requests\Admin\Items\CreateCategoryRequest;
use App\Http\Requests\Admin\Items\UpdateCategoryRequest;
use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $service;

    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        //$categories = Category::tree()->get()->toTree();
        //dd(Category::all()[0]->recursiveItems);
        //return view('admin.categories.test', compact('categories'));

        //dd(Category::all()->descendants());
        $categories = Category::whereParentId(null)->withCount([
            'items',
            'recursiveItems',
            'descendants',
            'children'
            ])->orderBy('sorting')->paginate(config('app.pagination_default_value'));
        return view('admin.categories.index', compact('categories'));
    }

    public function indexSubCategories()
    {
        //$subCategories = Category::whereNotNull('parent_id')->orderByDesc('created_at')->paginate(100);
        //return view('admin.subcategories.index', compact('subCategories'));
        //$categories = Category::whereParentId(null)->paginate(15);
        //$categories = Category::withCount('children')->paginate(15);
        $categories = Category::whereParentId(null)->withCount(['children'])->paginate(15);
        return view('admin.subcategories.index', compact('categories'));
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

    public function createSubCategory(Category $category)
    {

        //dd($category);
        //dd($request->all());
        //$selectCategory = Category::select(['id', 'title'])->whereParentId(null)
        //    ->orderBy('title')
        //    ->get();
        //
        //$categoriesToView = [];
        //
        //foreach ($selectCategory as $category) {
        //    $categoriesToView[$category->id] = mb_substr($category->title, 0, 60);
        //}
        return view('admin.subcategories.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        $filePath = $request->file('img') !== null ? $request->file('img')->getRealpath() : null;
        $category = new Category();
        $category->sorting = Category::whereParentId(null)->max('sorting') + 1;
        $category->title = $request->title;
        $category->img = is_null($filePath)
            ? null
            : $this->service->saveImageWithResize($filePath, 'categories');
        $category->save();
        return redirect()->route('admin.categories.index');
    }

    public function storeSubCategory(Category $category, CreateCategoryRequest $request)
    {
        $filePath = $request->file('img') !== null ? $request->file('img')->getRealpath() : null;
        $childCategory = new Category();
        $childCategory->sorting = Category::whereParentId($category->id)->max('sorting') + 1;
        $childCategory->title = $request->title;
        $childCategory->img = is_null($filePath)
            ? null
            : $this->service->saveImageWithResize($filePath, 'categories');
        $childCategory->parent_id = $category->id;
        $childCategory->save();

        return redirect()->route('admin.categories.show', $category);

        //Category::create([
        //    'title' => $request->title,
        //    'sorting' => Category::whereParentId($category->id)->max('sorting') + 1,
        //    'parent_id' => $category->id
        //]);

        //return redirect()->route('admin.categories.show', $category);
    }


    public function show(Category $category)
    {
        //dd($category->children->sortByDesc('sorting'));
        $category->loadCount([
            'items',
            'recursiveItems',
            //'descendants',
            'children'
        ]);
        return view('admin.categories.show', compact('category'));
    }

    public function showSubCategory(Category $category)
    {
        $category->loadCount([
            'items',
            'recursiveItems',
            'descendants',
            'children'
        ]);
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
        //dd($category);
        //dd($category);
        $selectCategory = Category::select(['id', 'title'])->whereParentId(null)
            ->orderBy('title')
            ->get();
        //
        $categoriesToView = [];

        foreach ($selectCategory as $cat) {
            $categoriesToView[$cat->id] = mb_substr($cat->title, 0, 60);
        }

        return view('admin.subcategories.edit', compact('category', 'categoriesToView'));
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
        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->getRealpath();
            $category->img = $this->service->saveImageWithResize($filePath, 'categories');
        }

        $category->slug = null;
        $category->title = $request->title;
        $category->save();
        //$category->update($request->only(['title']));
        //return redirect()->route('admin.categories.index');
        return redirect()->route('admin.categories.show', compact('category'));
    }

    public function updateSubCategory(UpdateCategoryRequest $request, Category $category)
    {
        //dd($request->all());
        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->getRealpath();
            $category->img = $this->service->saveImageWithResize($filePath, 'categories');
        }
        $category->slug = null;
        $category->title = $request->title;
        $category->parent_id = $request->parent_id;
        $category->save();
        //$category->update($request->only(['title', 'parent_id']));
        return redirect()->route('admin.subcategories.show', $category);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        try {
            $category->loadCount([
                'items',
                //'recursiveItems',
                //'descendants',
                'children'
            ]);
            //dump($category->items_count);
            //dump($category->children_count);
            //dd($category->items_count > 0 || $category->children_count > 0);

            if ($category->items_count > 0 || $category->children_count > 0) {
                return redirect()->back()->withErrors('Нельзя удалить категорию имеющую подкатегории или товары');
            }
            if ($category->delete()) {
                return redirect()->route('admin.categories.index');
            }
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            dd($errorMsg);
        }
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroySubCategory(Category $category)
    {
        $category->loadCount([
            'items',
            //'recursiveItems',
            //'descendants',
            //'children'
        ]);
        //dump($category->children_count);
        //dump($category->descendants_count);
        //dump($category->items_count);
        //dd($category->recursive_items_count);

        //if ($category->recursive_items_count > 0 || $category->descendants_count > 0) {
        if ($category->items_count > 0) {
            return redirect()->back()->withErrors('Нельзя удалить категорию имеющую подкатегории или товары');
        }
        //if ($category->items()->exists()) {
        //    return redirect()->back()->withErrors('');
        //}

        //dd(1);
        //if (!$category->items()->exists()) {
        //    $category->delete();
        //    return redirect()->route('admin.categories.show', $category->parent);
        //}

        if ($category->delete()) {
            return redirect()->route('admin.categories.show', $category->parent);
        }

        //return redirect()->route('admin.subcategories.show', $category)->with('errors', 'Ошибка соединения с базой данных');
        //return redirect()->route('admin.subcategories.show', $category)->withErrors(["your_custom_error"=>"Your custom error message!"]);
    }
}
