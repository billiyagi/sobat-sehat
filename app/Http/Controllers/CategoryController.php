<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->get('limit')) {
            $news = Category::all()->sortByDesc('created_at')->limit($request->get('limit'));
        } else {
            $news = Category::all()->sortByDesc('created_at');
        }

        if (!empty($news)) {
            return $this->responseSuccess($news);
        } else {
            return $this->responseNotFound();
        }
    }

    public function show($id)
    {
        $news = Category::find($id);

        if (!empty($news)) {
            return $this->responseSuccess($news);
        } else {
            return $this->responseNotFound();
        }
    }
}
