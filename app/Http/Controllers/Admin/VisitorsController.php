<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart\Token;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class VisitorsController extends Controller
{
    public function index()
    {
        try {
            $tokens = Token::orderByDesc('created_at')
                ->paginate(config('app.pagination_default_value'));
        } catch (QueryException $exception) {
            dd($exception->getMessage());
        }

        return view('admin.visitors.index', compact('tokens'));
    }
}
