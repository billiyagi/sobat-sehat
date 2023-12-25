<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventsRequest;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        if (!empty($events)) {
            return $this->responseSuccess($events);
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
        $event = Event::find($id);

        if (!empty($event)) {
            return $this->responseSuccess($event, 'Event dengan ID ' . $id . ' ditemukan.');
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

