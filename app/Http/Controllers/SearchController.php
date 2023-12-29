<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventsRequest;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function events(Request $request)
    {
        $events = DB::table('events')
            ->where('name', 'like', '%' . $request->get('query') . '%')
            ->get();

        $result = [];

        foreach ($events as $key => $value) {
            $result[$key] = [
                'id'            =>  $value->id,
                'name'          =>  $value->name,
                'end_at'        =>  $value->end_at,
                'start_at'      =>  $value->start_at,
                'link_location' =>  $value->link_location,
                'location_at'   =>  $value->location_at,
                'thumbnail'     =>  $value->thumbnail,
                'slug'          =>  $value->slug,
                'created_at'    =>  $value->created_at,
                'updated_at'    =>  $value->updated_at,
                'author'          =>  User::find($value->user_id)
            ];
        }

        return $this->responseSuccess($result);
    }

    public function news(Request $request)
    {
        $news = DB::table('news')
            ->where('title', 'like', '%' . $request->get('query') . '%')
            ->get();

        $result = [];

        foreach ($news as $key => $value) {
            $result[$key] = [
                'id'            =>  $value->id,
                'title'         =>  $value->title,
                'category_id'   =>  $value->category_id,
                'content'       =>  $value->content,
                'publish_at'    =>  $value->published_at,
                'status'        =>  $value->status,
                'thumbnail'     =>  $value->thumbnail,
                'user_id'       =>  $value->user_id,
                'slug'          =>  $value->slug,
                'created_at'    =>  $value->created_at,
                'updated_at'    =>  $value->updated_at,
                'category'      =>  Category::find($value->category_id),
                'author'          =>  User::find($value->user_id)
            ];
        }
        return $this->responseSuccess($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
