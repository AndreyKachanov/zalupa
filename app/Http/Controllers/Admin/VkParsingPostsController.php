<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ParsingVkPostsRequest;
use App\Services\Vk\ParsingPostsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class VkParsingPostsController
{
    private $service;

    public function __construct(ParsingPostsService $service)
    {
//        $this->middleware('can:vk-parser');
//        dd(1);
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.parser.index');
    }

    /**
     * @param ParsingVkPostsRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function startParse(ParsingVkPostsRequest $request)
    {
//        dd(1);
        $userId = Auth::id();
//        dd($userId);
        //$groupsFromVk = $this->service->getGroups($request->get('groups'));
        $groupsFromVk = Cache::get('parsing_vk_groups_live')[$userId];
//        dd($groupsFromVk);

        $this->service->sendDataToPusher(
            $userId,
            $groupsFromVk,
            $request->get('keywords'),
            $request->get('days')
        );
//        dd(111);
        return response()->json('data sent');
    }
}
