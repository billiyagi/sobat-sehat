<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function getSubscribers(Request $request)
    {
        $subscribers = DB::table('subscribers')->get();

        return $this->responseSuccess([
            'total_subscribers' => count($subscribers),
        ]);
    }

    public function getTotalEvents()
    {
        $events = DB::table('events')->get();

        return $this->responseSuccess([
            'total_events' => count($events),
        ]);
    }

    public function getTotalNews()
    {
        $news = DB::table('news')->get();

        return $this->responseSuccess([
            'total_news' => count($news),
        ]);
    }

    public function getUserRegisterEvents()
    {
        $userRegisterEvents = DB::table('register_event')->get();

        return $this->responseSuccess([
            'total_user_register_events' => count($userRegisterEvents),
        ]);
    }

    public function getRecentEvents()
    {
        $events = DB::table('events')->orderBy('created_at', 'desc')->take(5)->get();

        return $this->responseSuccess([
            'recent_events' => $events,
        ]);
    }
}
