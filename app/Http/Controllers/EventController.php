<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = [
            [
                'id' => 1,
                'title' => 'Event 1',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                'location' => 'Jakarta',
                'date' => '2021-01-01',
                'time' => '19:00:00',
            ],
            [
                'id' => 2,
                'title' => 'Event 2',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                'location' => 'Jakarta',
                'date' => '2021-01-01',
                'time' => '19:00:00',
            ],
            [
                'id' => 3,
                'title' => 'Event 3',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                'location' => 'Jakarta',
                'date' => '2021-01-01',
                'time' => '19:00:00',
            ],
        ];

        return $this->responseSuccess($events);
    }
}
