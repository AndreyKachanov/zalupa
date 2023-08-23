<?php

namespace App\Http\Controllers\Admin\Items;

use App\Models\Admin\Item\Category;
use App\Http\Requests\Admin\Items\CreateCategoryRequest;
use App\Http\Requests\Admin\Items\UpdateCategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Item\Item;
use App\Services\ImageService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private ImageService $service;

    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        //$categories = Category::defaultOrder()->withCount(['items', 'orders'])->withDepth()->get();
        $categories = Category::defaultOrder()
            ->withCount(['items', 'orders' => function ($query) {
                $query->whereDoesntHave('contact', function ($subQuery) {
                    $subQuery->onlyTrashed();
                });
            }])
            ->withDepth()
            ->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = $this->getCategories();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        $filePath = $request->file('img') !== null ? $request->file('img')->getRealpath() : null;
        $category = new Category();
        $category->parent_id = $request->parent;
        $category->title = $request->title;
        $category->img = is_null($filePath)
            ? null
            : $this->service->saveImageWithResize($filePath, 'categories');
        $category->save();
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function show(Category $category)
    {
        $category->loadCount([
            'items',
            'children'
        ]);
        $categories = $category->descendants()->pluck('id');
        $categories[] = $category->getKey();
        $countRelatedModels = Item::whereIn('category_id', $categories)->count();
        return view('admin.categories.show', compact('category', 'countRelatedModels'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        $categories = $this->getCategories();
        return view('admin.categories.edit', compact('category', 'categories'));
    }


    /**
     * @param CreateCategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateCategoryRequest $request, Category $category)
    {
        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->getRealpath();
            $category->img = $this->service->saveImageWithResize($filePath, 'categories');
        }
        $category->slug = null;
        $category->parent_id = $request->parent;
        $category->title = $request->title;
        $category->save();
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
     */
    public function destroy(Category $category)
    {
        try {
            $category->loadCount([
                'items',
                'children'
            ]);

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

    public function first(Category $category)
    {
        if ($first = $category->siblings()->defaultOrder()->first()) {
            $category->insertBeforeNode($first);
        }

        return redirect()->route('admin.categories.index');
    }

    public function up(Category $category)
    {
        $category->up();

        return redirect()->route('admin.categories.index');
    }

    public function down(Category $category)
    {
        $category->down();

        return redirect()->route('admin.categories.index');
    }

    public function last(Category $category)
    {
        if ($last = $category->siblings()->defaultOrder('desc')->first()) {
            $category->insertAfterNode($last);
        }

        return redirect()->route('admin.categories.index');
    }

    public function test(Category $category)
    {

        //$category->load('orders.contact.token.invoice', 'orders.item');

        $category->load([
            'orders' => function ($query) {
                // Загружаем только "orders", у которых не удалены "contact"
                $query->whereDoesntHave('contact', function ($subQuery) {
                    $subQuery->onlyTrashed();
                })->orderBy('created_at');;
            },
            'orders.contact.token.invoice', // Загружаем связанные записи
            'orders.item' // Загружаем "orders.item"
        ]);
        return view('admin.categories.test2', compact('category'));
    }

    /**
     * @return array
     */
    private function getCategories(): array
    {
        $categories = Category::defaultOrder()->withDepth()->get()->each(
            function (Category $category) {
                $str = '';
                for ($i = 0; $i < $category->depth; $i++) {
                    $str .= html_entity_decode('&mdash; ', 0, "UTF-8");
                }
                $category->title = $str . $category->title;
            }
        )->pluck('title', 'id')->toArray();

        return Arr::prepend($categories, '', '');
    }
}
