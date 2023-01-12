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
        //dump($request->all());
        if (isset($request->find)) {
            $request->validate([
                //'search_checkbox' => 'required',
                'search_input' => 'required'
            ]);
        }
        //dump(isset($request->find));
        //dump($request->all());
        //dump($request->find);


        //dd(Category::where('title','LIKE', "%{$request->search}%")->pluck('id')->toArray());
        //$request->flash();

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

        $items = $query->paginate(20);
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
        $item->note = $request->note;
        $item->article_number = $request->article_number;
        $item->price = $request->price;
        $item->is_new = isset($request->is_new);
        $item->is_hit = isset($request->is_hit);
        $item->is_bestseller = isset($request->is_bestseller);
        $item->img = $this->service->saveImageWithResize($filePath);
        $item->category_id = $request->category_id;
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
        $item->note = $request->note;
        $item->article_number = $request->article_number;
        $item->price = $request->price;
        $item->is_new = isset($request->is_new);
        $item->is_hit = isset($request->is_hit);
        $item->is_bestseller = isset($request->is_bestseller);
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
