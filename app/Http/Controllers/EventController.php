<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventsRequest;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

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

        if (!empty($events)) {
            return $this->responseSuccess($result);
        } else {
            return $this->responseNotFound();
        }
    }

    public function store(EventsRequest $request, Event $event)
    {
        // Generate random file name
        $thumbnailFileName = uniqid() . '.' . $request->file('thumbnail')->extension();

        // Set data
        $event = [
            'name'          =>  $request->name,
            'description'   =>  $request->description,
            'location_at'   =>  $request->location_at,
            'link_location' =>  $request->link_location,
            'start_at'      =>  $request->start_at,
            'end_at'        =>  $request->end_at,
            'thumbnail'     =>  '/assets/img/thumbnail/' . $thumbnailFileName,
            'user_id'       =>  auth()->user()->id,
            'slug'          =>  Str::of($request->name)->slug('-')
        ];

        // Store data
        if (Event::create($event)) {

            // Store image
            $request->file('thumbnail')->storeAs('public/assets/img/thumbnail', $thumbnailFileName);

            return $this->responseSuccess($event, 'Event created succesfully.');
        } else {
            return $this->responseError();
        }
    }

    public function update(EventsRequest $request, Event $event, $id)
    {

        $event = Event::find($id);

        // Check if thumbnail is uploaded
        if ($request->hasFile('thumbnail')) {

            // Generate random file name
            $thumbnailFileName = uniqid() . '.' . $request->file('thumbnail')->extension();

            // Store image
            $request->file('thumbnail')->storeAs('public/assets/img/thumbnail', $thumbnailFileName);

            // Delete old image if not default
            if ($event->thumbnail != 'default-thumbnail.png') {
                // Delete old image
                Storage::delete('public' . $event->thumbnail);
            }
        } else {
            $thumbnailFileName = null;
        }



        // Set data
        $events = [
            'name'          =>  $request->name,
            'description'   =>  $request->description,
            'location_at'   =>  $request->location_at,
            'link_location' =>  $request->link_location,
            'start_at'      =>  $request->start_at,
            'end_at'        =>  $request->end_at,
            'thumbnail'     => (empty($thumbnailFileName)) ? $event->thumbnail : '/assets/img/thumbnail/' . $thumbnailFileName,
            'user_id'       =>  auth()->user()->id,
            'slug'          =>  $event->slug
        ];

        // Store data
        if (Event::where('id', $id)->update($events)) {
            return $this->responseSuccess($events, 'Event updated succesfully.');
        } else {
            return $this->responseError();
        }
    }

    public function show($id)
    {
        $getEvent = Event::find($id);

        $event = [
            'id'            =>  $getEvent->id,
            'name'          =>  $getEvent->name,
            'end_at'        =>  $getEvent->end_at,
            'start_at'      =>  $getEvent->start_at,
            'link_location' =>  $getEvent->link_location,
            'location_at'   =>  $getEvent->location_at,
            'thumbnail'     =>  $getEvent->thumbnail,
            'slug'          =>  $getEvent->slug,
            'created_at'    =>  $getEvent->created_at,
            'updated_at'    =>  $getEvent->updated_at,
            'author'          =>  User::find($getEvent->user_id)
        ];

        if (!empty($event)) {
            return $this->responseSuccess($event, 'Event dengan ID ' . $id . ' ditemukan.');
        } else {
            return $this->responseNotFound();
        }
    }

    public function showBySlug($slug)
    {
        $getEvent = Event::where('slug', $slug)->first();

        $event = [
            'id'            =>  $getEvent->id,
            'name'          =>  $getEvent->name,
            'end_at'        =>  $getEvent->end_at,
            'start_at'      =>  $getEvent->start_at,
            'link_location' =>  $getEvent->link_location,
            'description' =>  $getEvent->description,
            'location_at'   =>  $getEvent->location_at,
            'thumbnail'     =>  $getEvent->thumbnail,
            'slug'          =>  $getEvent->slug,
            'created_at'    =>  $getEvent->created_at,
            'updated_at'    =>  $getEvent->updated_at,
            'author'          =>  User::find($getEvent->user_id)
        ];

        if (!empty($event)) {
            return $this->responseSuccess($event, 'Event dengan ID ' . $slug . ' ditemukan.');
        } else {
            return $this->responseNotFound();
        }
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        if (!empty($event)) {

            // Delete old image
            Storage::delete('public' . $event->thumbnail);

            // Delete data
            if (Event::destroy($id)) {
                return $this->responseSuccess([], 'Event dengan ID ' . $id . ' dihapus.');
            } else {
                return $this->responseError();
            }
        } else {
            return $this->responseNotFound();
        }
    }

    public function featured()
    {
        $events = DB::table('events')->limit(1)->get();

        if (!empty($events)) {
            return $this->responseSuccess($events);
        } else {
            return $this->responseNotFound();
        }
    }
}
