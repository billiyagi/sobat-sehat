<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->get('limit')) {
            $news = DB::table('news')->limit($request->get('limit'))->get();
        } else {
            $news = News::all();
        }

        $result = [];

        foreach ($news as $key => $value) {
            $result[$key] = [
                'id'            =>  $value->id,
                'title'         =>  $value->title,
                'category_id'   =>  $value->category_id,
                'content'       =>  $value->content,
                'published_at'    =>  $value->published_at,
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

        if (!empty($news)) {
            return $this->responseSuccess($result);
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
            'title'         =>  $request->title,
            'category_id'   =>  $request->category_id,
            'content'       =>  $request->content,
            'publish_at'    =>  null,
            'status'        =>  $request->status,
            'thumbnail'     =>  '/assets/img/thumbnail/' . $thumbnailFileName,
            'user_id'       =>  auth()->user()->id,
            'slug'          =>  Str::of($request->title)->slug('-')
        ];

        // Store data
        if (News::create($news)) {

            // Store image
            $request->file('thumbnail')->storeAs('public/assets/img/thumbnail', $thumbnailFileName);

            return $this->responseSuccess($news, 'News created succesfully.');
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
        $news = News::find($id);

        $result = [
            'id'            =>  $news->id,
            'title'         =>  $news->title,
            'category_id'   =>  $news->category_id,
            'content'       =>  $news->content,
            'publish_at'    =>  $news->publish_at,
            'status'        =>  $news->status,
            'thumbnail'     =>  $news->thumbnail,
            'user_id'       =>  $news->user_id,
            'slug'          =>  $news->slug,
            'created_at'    =>  $news->created_at,
            'updated_at'    =>  $news->updated_at,
            'deleted_at'    =>  $news->deleted_at,
            'category'      =>  Category::find($news->category_id),
            'author'        =>  User::find($news->user_id)
        ];

        if (!empty($news)) {
            return $this->responseSuccess($result, 'News dengan ID ' . $id . ' ditemukan.');
        } else {
            return $this->responseNotFound();
        }
    }

    /**
     * Display the specified resource.
     */
    public function showBySlug(string $slug)
    {
        $news = News::where('slug', $slug)->first();

        $result = [
            'id'            =>  $news->id,
            'title'         =>  $news->title,
            'category_id'   =>  $news->category_id,
            'content'       =>  $news->content,
            'publish_at'    =>  $news->publish_at,
            'status'        =>  $news->status,
            'thumbnail'     =>  $news->thumbnail,
            'user_id'       =>  $news->user_id,
            'slug'          =>  $news->slug,
            'created_at'    =>  $news->created_at,
            'updated_at'    =>  $news->updated_at,
            'deleted_at'    =>  $news->deleted_at,
            'category'      =>  Category::find($news->category_id),
            'author'        =>  User::find($news->user_id)
        ];

        if (!empty($news)) {
            return $this->responseSuccess($result, 'News dengan slug ' . $slug . ' ditemukan.');
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
            'category_id'   =>  $request->category_id,
            'content'       =>  $request->content,
            'status'        =>  $request->status,
            'thumbnail'     =>  '/assets/img/thumbnail/' . $thumbnailFileName,
            'user_id'       =>  auth()->user()->id,
            'slug'          =>  Str::of($request->name)->slug('-')
        ];

        // Store data
        if (News::where('id', $id)->update($news)) {
            return $this->responseSuccess($news, 'News updated succesfully.');
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
                return $this->responseSuccess([], 'News dengan ID ' . $id . ' dihapus.');
            } else {
                return $this->responseError();
            }
        } else {
            return $this->responseNotFound();
        }
    }
}
