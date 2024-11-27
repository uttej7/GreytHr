<?php

use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.EmployeeDetails.{emp_id}', function ($user, $emp_id) {
    Log::info('Broadcast channel authorization called', ['emp_id' => $emp_id]);
    return (int) $user->emp_id === (int) $emp_id;
});

Broadcast::channel('chat.{receiver}', function (EmployeeDetails $user, $receiver) {

    #check if user is same as receiver

    return (int) $user->emp_id === (int) $receiver;
});
