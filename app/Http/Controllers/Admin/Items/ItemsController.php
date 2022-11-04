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
        $query = Item::orderByDesc('created_at');

//        if ($request->has('search_by_item')) {
        if (!empty($value = $request->get('title'))) {
            $query->where('title', 'LIKE', "%{$value}%");
        }

        if (!empty($value = $request->get('article_number'))) {
            $query->where('article_number', 'LIKE', "%{$value}%");
        }

        if (!empty($value = $request->get('price1'))) {
            $query->where('price1', $value);
        }

        if (!empty($value = $request->get('price2'))) {
            $query->where('price2', $value);
        }

        if (!empty($value = $request->get('price3'))) {
            $query->where('price3', $value);
        }

        if (!empty($value = $request->get('category_id'))) {
            $query->where('category_id', $value);
        }
//        }

        $items = $query->paginate(100);
        $categories = Category::all();
        return view('admin.items.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::get(['id', 'title']);
//        dd($categories);
        return view('admin.items.create', compact('categories'));
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
        $item->article_number = $request->article_number;
        $item->price1 = $request->price1;
        $item->price2 = $request->price2;
        $item->price3 = $request->price3;
        $item->link = $request->link;
        $item->img = $this->service->saveImageWithResize($filePath);
        $item->category_id = $request->category_id;
        $item->save();
        return redirect()->route('admin.items.show', $item);
    }

    /**
     * @param  Item  $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Item $item)
    {
        return view('admin.items.show', compact('item'));
    }

    /**
     * @param  Item  $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'categories'));
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
            $item->img = $this->service->saveImageWithResize($filePath);
        }

        $item->title = $request->title;
        $item->article_number = $request->article_number;
        $item->price1 = $request->price1;
        $item->price2 = $request->price2;
        $item->price3 = $request->price3;
        $item->link = $request->link;
        $item->category_id = $request->category_id;
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
