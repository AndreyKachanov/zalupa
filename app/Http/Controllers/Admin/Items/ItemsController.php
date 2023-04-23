<?php

namespace App\Http\Controllers\Admin\Items;

use App\Models\Admin\Item\Category;
use App\Http\Requests\Admin\Items\CreateItemRequest;
use App\Models\Admin\Item\Item;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ItemsController extends Controller
{
    private ImageService $service;

    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }


    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {
        if (isset($request->find)) {
            $max = 100;
            $validator = Validator::make($request->all(), [
                'radio_search_by' => 'required',
                'search_input' => "required|string|max:$max"
            ], [
                'radio_search_by.required' => 'Выберите категорию поиска',
                'search_input.max' => '<b>:attribute</b> не должна превышать :max ' .  Lang::choice('символ|символа|символов', $max) . ''
            ], [
                'search_input' => 'Строка поиска',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        $oldRadioButton = isset($request->radio_search_by) ? $request->radio_search_by : 'title';
        $oldSearchInput = $request->search_input;

        $query = Item::orderByDesc('created_at');

        if ($request->radio_search_by === 'title') {
            $query->where('title', 'LIKE', "%{$request->search_input}%");
        }

        if ($request->radio_search_by === 'article_number') {
            $query->where('article_number', 'LIKE', "%{$request->search_input}%");
        }

        if ($request->radio_search_by === 'category') {
            $ids = Category::where('title', 'LIKE', "%{$request->search_input}%")->pluck('id')->toArray();
            $query->whereIn('category_id', $ids);
        }

        $items = $query->with('category')->paginate(config('app.pagination_default_value'));
        return view('admin.items.index', compact('items','oldSearchInput', 'oldRadioButton'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = $this->getCategories();
        return view('admin.items.create', compact('categories'));
    }

    /**
     * @param CreateItemRequest $request
     * @return RedirectResponse
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
        $item->category_id = $request->category;
        $item->save();
        $item->update(['article_number' => $item->id . '.' . $item->article_number]);
        return redirect()->route('admin.items.show', $item);
    }

    /**
     * @param Item $item
     * @return Application|Factory|View
     */
    public function show(Item $item)
    {
        $item->load('category');
        return view('admin.items.show', compact('item'));
    }

    /**
     * @param Item $item
     * @return Application|Factory|View
     */
    public function edit(Item $item)
    {
        $categories = $this->getCategories();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    /**
     * @param CreateItemRequest $request
     * @param Item $item
     * @return RedirectResponse
     */
    public function update(CreateItemRequest $request, Item $item)
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
        $item->category_id = $request->category;
        $item->save();
        return redirect()->route('admin.items.show', compact('item'));
    }

    /**
     * @param Item $item
     * @return RedirectResponse
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('admin.items.index');
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
        );

        return $categories->pluck('title', 'id')->toArray();
    }
}
