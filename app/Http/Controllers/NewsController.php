<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $news = news::all();

        if (!empty($news)) {
            return $this->responseSuccess($news);
        } else {
            return $this->responseNotFound();
        }
    }

    public function store(NewsRequest $request, News $news)
    {
        // Generate random file name
        $thumbnailFileName = uniqid() . '.' . $request->file('thumbnail')->extension();

        // Set data
        $news = [
            'id'            =>  $request->id,
            'category_id'   =>  $request->category_id,
            'content'       =>  $request->content,
            'publish_at'    =>  $request->publish_at,
            'status'        =>  $request->status,
            'create_at'     =>  $request->create_at,
            'update_at'     =>  $request->update_at,
            'thumbnail'     =>  '/assets/img/thumbnail/' . $thumbnailFileName,
            'user_id'       =>  auth()->user()->id,
            'slug'          =>  Str::of($request->name)->slug('-')
        ];

        // Store data
        if (News::create($news)) {

            // Store image
            $request->file('thumbnail')->storeAs('public/assets/img/thumbnail', $thumbnailFileName);

            return $this->responseSuccess($event, 'Event created succesfully.');
        } else {
            return $this->responseError();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $news = Event::find($id);

        if (!empty($news)) {
            return $this->responseSuccess($news, 'Berita dengan ID ' . $id . ' ditemukan.');
        } else {
            return $this->responseNotFound();
        }
    }

    
    public function update(Request $request, string $id)
    {
        //
        $news = News::find($id);

        // Check if thumbnail is uploaded
        if ($request->hasFile('thumbnail')) {

            // Generate random file name
            $thumbnailFileName = uniqid() . '.' . $request->file('thumbnail')->extension();

            // Store image
            $request->file('thumbnail')->storeAs('public/assets/img/thumbnail', $thumbnailFileName);

            // Delete old image if not default
            if ($news->thumbnail != 'default-thumbnail.png') {
                // Delete old image
                Storage::delete('public' . $news->thumbnail);
            }
        } else {
            $thumbnailFileName = null;
        }

        // Set data
        $news = [
            'id'            =>  $request->id,
            'category_id'   =>  $request->category_id,
            'content'       =>  $request->content,
            'publish_at'    =>  $request->publish_at,
            'status'        =>  $request->status,
            'create_at'     =>  $request->create_at,
            'update_at'     =>  $request->update_at,
            'thumbnail'     =>  '/assets/img/thumbnail/' . $thumbnailFileName,
            'user_id'       =>  auth()->user()->id,
            'slug'          =>  Str::of($request->name)->slug('-')
        ];

        // Store data
        if ($news::where('id', $id)->update($news)) {
            return $this->responseSuccess($news, 'news updated succesfully.');
        } else {
            return $this->responseError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $news = News::find($id);

        if (!empty($news)) {

            // Delete old image
            Storage::delete('public' . $news->thumbnail);

            // Delete data
            if ($news::destroy($id)) {
                return $this->responseSuccess([], 'Berita dengan ID ' . $id . ' dihapus.');
            } else {
                return $this->responseError();
            }
        } else {
            return $this->responseNotFound();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
}
