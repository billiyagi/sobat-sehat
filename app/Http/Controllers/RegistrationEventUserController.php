<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrationEventUser;

class RegistrationEventUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'arrival_at' => 'required',
        ]);

        if (RegistrationEventUser::create($validateData)) {
            return $this->responseSuccess($validateData, 'Anda berhasil registrasi event.');
        } else {
            return $this->responseError();
        }

        // $registrationEventUser = RegistrationEventUser::create($validateData);
        // $registrationEventUsername = User::find($validateData['user_id']);
        // $registrationEventUserEventname = Event::find($validateData['event_id']);

        // $data = [
        //     'messages' => 'Berhasil Registrasi Event',
        //     'data' => [
        //                 'Registration Event User' => $registrationEventUsers,
        //                 'Registration Event Username' => $registrationEventUsername,
        //                 'Registration Event User Eventname' => $registrationEventUserEventname,
        //             ],
        // ];
        
        // return response()->json($data, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
