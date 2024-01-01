<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscribeController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::all();

        return $this->responseSuccess($subscribers);
    }

    public function store(Request $request)
    {
        // cari apakah email sudah ada di database
        if (Subscriber::where('email', $request->get('email'))->first()) {
            return $this->responseError('Email already exists.', 400);
        }

        $subscriber = Subscriber::create([
            'email' => $request->get('email'),
        ]);

        $subscriber->save();

        return $this->responseSuccess($subscriber, 'Subscriber created succesfully.');
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::find($id);

        if (!$subscriber) {
            return $this->responseError('Subscriber not found.', 404);
        }

        $subscriber->delete();

        return $this->responseSuccess(null, 'Subscriber deleted succesfully.');
    }
}
