<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrationEvent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegistrationEventController extends Controller
{
    // get all registration event and grouped by month
    public function index()
    {
        $registrationEvents = DB::table('register_event')
            ->select(DB::raw('count(*) as total, MONTH(created_at) as month, YEAR(created_at) as year'))
            ->groupBy('month', 'year')
            ->get();


        if (!empty($registrationEvents)) {
            return $this->responseSuccess($registrationEvents);
        } else {
            return $this->responseNotFound();
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(), 400);
        }

        $registrationEvent = RegistrationEvent::create([
            'user_id' => $request->input('user_id'),
            'event_id' => $request->input('event_id'),
        ]);

        $registrationEvent->save();

        return $this->responseSuccess($registrationEvent, 'Registration Event created succesfully.');
    }


    public function isRegistered(Request $request, $id)
    {
        $user = auth()->user();

        $registrationEvent = RegistrationEvent::where('user_id', $user->id)->where('event_id', $id)->first();

        return response()->json([
            'message' => 'User is registered to this event.',
            'data' => null,
            'status'  => $registrationEvent ? true : false,
            'user'  =>  $user,
        ], 200);
    }
}
