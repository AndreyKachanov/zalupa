<?php

namespace App\Http\Controllers\Admin\Items;

use App\Models\Admin\Item\Category;
use App\Http\Requests\Admin\Items\CreateItemRequest;
use App\Http\Requests\Admin\Items\UpdateItemRequest;
use App\Models\Admin\Item\Item;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemsController extends Controller
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
    public function index(Request $request)
    {
        if (isset($request->find)) {
            $request->validate([
                'search_input' => 'required'
            ]);
        }
        $request->flashOnly([
            'checkbox_title',
            'checkbox_article_number',
            'checkbox_category',
            'search_input'
        ]);

        $query = Item::orderByDesc('created_at');

        if (isset($request->checkbox_title)) {
            $query->where('title', 'LIKE', "%{$request->search_input}%");
        }

        if (isset($request->checkbox_article_number)) {
            $query->where('article_number', 'LIKE', "%{$request->search_input}%");
        }

        if (isset($request->checkbox_category)) {
            $ids = Category::where('title', 'LIKE', "%{$request->search_input}%")->pluck('id')->toArray();
            $query->whereIn('category_id', $ids);
        }

        $items = $query->with('rCategory')->paginate(config('app.pagination_default_value'));
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->orderBy('sorting')->get(['id', 'title']);
        $categoryToView = [];
        $subCategoryToView = [];
        foreach ($categories as $category) {
            $categoryToView[$category->id] = mb_substr($category->title, 0, 90);
        }

        $selectSubCategory = Category::select(['id', 'title'])
            ->where('parent_id', key($categoryToView))
            ->orderBy('sorting')
            ->get();

        if ($selectSubCategory->count() > 0) {
            $subCategoryToView = [];
            $subCategoryToView[0] = 'Выберите подкатегорию';

            foreach ($selectSubCategory as $s) {
                $subCategoryToView[$s->id] = mb_substr($s->title, 0, 90);
            }
        }

        //dd($categoryToView);

        return view('admin.items.create', [
            'selectCategory'    => $categoryToView ?? null,
            'selectSubCategory' => $subCategoryToView ?? [],
        ]);
    }

    public function getSubCategories(Request $request, $id)
    {
        $subCategories = Category::select(['id', 'title'])
            ->where('parent_id', $id)
            ->orderBy('sorting')
            ->get();

        if ($subCategories->count() > 0) {
            $subCategoriesToSession = [];
            $subCategoriesToSession['0'] = 'Выберите подкатегорию';

            foreach ($subCategories as $category) {
                $subCategoriesToSession[$category->id] = $category->title;
            }

            $request->session()->put('create_sub_categories.arr', $subCategoriesToSession);
            return response()->json(['sub_categories' => $subCategories], 200);
        }

        $request->session()->put('create_sub_categories.arr', []);
        return response()->json(['sub_categories' => []], 200);
    }

    /**
     * @param  CreateItemRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateItemRequest $request)
    {
        $filePath = $request->file('img')->getRealpath();
        $item = new Item();
        $item->title = $request->title;
        $item->note = $request->note;
        $item->article_number = $request->article_number;
        $item->price = $request->price;
        $item->is_new = isset($request->is_new);
        $item->is_hit = isset($request->is_hit);
        $item->is_bestseller = isset($request->is_bestseller);
        $item->img = $this->service->saveImageWithResize($filePath, 'items');
        $item->category_id = (isset($request->sub_category_id) && $request->sub_category_id != '0')
            ? $request->sub_category_id
            : $request->category_id;
        $item->save();
        $item->update(['article_number' => $item->id . '.' . $item->article_number]);
        return redirect()->route('admin.items.show', $item);
    }

    /**
     * @param  Item  $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Item $item)
    {
        $item->load('rCategory');
        return view('admin.items.show', compact('item'));
    }

    /**
     * @param  Item  $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Item $item)
    {
        $mainCategories = Category::select(['id', 'title'])
            ->whereNull('deleted_at')
            ->whereNull('parent_id')
            ->orderBy('sorting')
            ->get();

        $mainCategoriesArray = [];
        $subCategoriesArray = [];

        foreach ($mainCategories as $c) {
            $mainCategoriesArray[$c->id] = mb_substr($c->title, 0, 90);
        }

        // id of parent category
        if (isset($item->rCategory)) {
            $parentCategoryId = $item->rCategory->parent_id;

            // If the analysis has a category with parent_id = null
            if ($parentCategoryId == null) {
                $subCategories = Category::select(['id', 'title'])
                    ->where('parent_id', $item->rCategory->id)
                    ->orderBy('sorting')
                    ->get();

                // If this category has children
                if ($subCategories->count() > 0) {
                    $subCategoriesArray[0] = "Выберите подкатегорию";
                }

                // otherwise the array will be empty
            } else {
                // selects all subcategories from the main category where the analysis is located
                $subCategories = Category::select(['id', 'title'])
                    ->where('parent_id', $parentCategoryId)
                    ->orderBy('sorting')
                    ->get();

                $subCategoriesArray = [];
                $subCategoriesArray[0] = "Выберите подкатегорию";
            }

            foreach ($subCategories as $s) {
                $subCategoriesArray[$s->id] = mb_substr($s->title, 0, 90);
            }
        } else {
            // selects all subcategories from first main category
            $subCategories = Category::select(['id', 'title'])
                ->where('parent_id', $mainCategories[0]->id)
                ->orderBy('sorting')
                ->get();

            $subCategoriesArray = [];
            $subCategoriesArray[0] = "Выберите подкатегорию";

            foreach ($subCategories as $s) {
                $subCategoriesArray[$s->id] = mb_substr($s->title, 0, 90);
            }
        }

        //$categories = Category::all();
        return view('admin.items.edit', [
            'item'             => $item,
            'mainCategoriesArray' => $mainCategoriesArray ?? null,
            'subCategoriesArray'  => $subCategoriesArray
        ]);
    }

    /**
     * @param  UpdateItemRequest  $request
     * @param  Item  $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->getRealpath();
            $item->img = $this->service->saveImageWithResize($filePath, 'items');
        }

        $item->title = $request->title;
        $item->note = $request->note;
        $item->article_number = $request->article_number;
        $item->price = $request->price;
        $item->is_new = isset($request->is_new);
        $item->is_hit = isset($request->is_hit);
        $item->is_bestseller = isset($request->is_bestseller);
        //$item->category_id = $request->category_id;
        $item->category_id = (isset($request->sub_category_id) && $request->sub_category_id != '0')
            ? $request->sub_category_id
            : $request->category_id;
        $item->save();
        return redirect()->route('admin.items.show', compact('item'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('admin.items.index');
    }
}
