<?php

namespace App\Http\Controllers\Admin\Items;

use App\Models\Admin\Item\Category;
use App\Http\Requests\Admin\Items\CreateCategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Item\Item;
use App\Services\ImageService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    private ImageService $service;

    /**
     * @param ImageService $service
     */
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
        $categories = $this->getCategoriesWithTree();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * @param CreateCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            $filePath = $request->file('img') !== null ? $request->file('img')->getRealpath() : null;
            $category = new Category();
            $category->parent_id = $request->get('parent');
            $category->title = $request->get('title');
            $category->img = is_null($filePath)
                ? null
                : $this->service->saveImageWithResize($filePath, 'categories');
            $category->save();
            return redirect()->route('admin.categories.index');
        } catch (Exception $exception) {
            writeErrorToFile($exception->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors('Ошибка сохранения категории. См. лог.');
        }
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function show(Category $category)
    {
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
        $categories = $this->getCategoriesWithTree();
        return view('admin.categories.edit', compact('category', 'categories'));
    }


    /**
     * @param CreateCategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CreateCategoryRequest $request, Category $category)
    {
        try {
            if ($request->hasFile('img')) {
                $filePath = $request->file('img')->getRealpath();
                $category->img = $this->service->saveImageWithResize($filePath, 'categories');
            }
            $category->slug = null;
            $category->parent_id = $request->get('parent');
            $category->title = $request->get('title');
            $category->save();
            return redirect()->route('admin.categories.show', compact('category'));
        } catch (Exception $exception) {
            writeErrorToFile($exception->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors('Ошибка обновления категории. См. лог.');
        }
    }

    /**
     * @param Category $category
     * @return RedirectResponse|void
     */
    public function destroy(Category $category)
    {
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
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     */
    public function first(Category $category)
    {
        if ($first = $category->siblings()->defaultOrder()->first()) {
            $category->insertBeforeNode($first);
        }
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     */
    public function up(Category $category)
    {
        $category->up();

        return redirect()->route('admin.categories.index');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     */
    public function down(Category $category)
    {
        $category->down();

        return redirect()->route('admin.categories.index');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     */
    public function last(Category $category)
    {
        if ($last = $category->siblings()->defaultOrder('desc')->first()) {
            $category->insertAfterNode($last);
        }

        return redirect()->route('admin.categories.index');
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function showOrders(Category $category)
    {
        $category->load([
            'orders' => function ($query) {
                // Загружаем только "orders", у которых не удалены "contact"
                $query->whereDoesntHave('contact', function ($subQuery) {
                    $subQuery->onlyTrashed();
                })->orderByDesc('created_at');
            },
            'orders.contact.token.invoice', // Загружаем связанные записи
            'orders.item' // Загружаем "orders.item"
        ]);
        return view('admin.categories.show_orders', compact('category'));
    }

    /**
     * @return array
     */
    private function getCategoriesWithTree(): array
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
