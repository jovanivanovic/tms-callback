<?php

namespace App\Http\Controllers;

use App\Callback;
use App\Http\Requests\CallbackFormStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterval;

class CallbackController extends Controller
{
    public function times(Request $request)
    {
        $availableTimes = [
            0 => null,
            1 => [ 'start' => 8, 'end' => 20 ],
            2 => [ 'start' => 8, 'end' => 20 ],
            3 => [ 'start' => 8, 'end' => 20 ],
            4 => [ 'start' => 8, 'end' => 20 ],
            5 => [ 'start' => 8, 'end' => 20 ],
            6 => [ 'start' => 8, 'end' => 13 ],
        ];

        $date = explode('/', $request->date);
        $date = Carbon::create($date[2], $date[1], $date[0]);

        $dateWeekday = $date->weekday();

        $slotLength = CarbonInterval::minutes(30);
        $currentTimespan = $availableTimes[$dateWeekday];
        $availableTimeSlots = [];

        $start = Carbon::instance($date)->setHour($currentTimespan['start']);
        $end = Carbon::instance($date)->setHour($currentTimespan['end']);

        if ($currentTimespan != null) {
            foreach (new \DatePeriod($start, $slotLength, $end) as $slot) {
                array_push($availableTimeSlots, $slot->format('H:i'));
            }
        }

        return response()->json($availableTimeSlots);
    }

    public function submit(CallbackFormStoreRequest $request)
    {
        $callback_date = explode('/', $request->callback_date);
        $callback_time = explode(':', $request->callback_time);

        $datetime = Carbon::create($callback_date[2], $callback_date[1], $callback_date[0], $callback_time[0], $callback_time[1]);

        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'order_number' => $request->order_number ?: '',
            'email' => $request->email ?: '',
            'issue' => $request->issue,
            'datetime' => $datetime
        ];

        $callback = Callback::create($data);

        return response()->json([ "message" => true, "callback" => $callback ]);
    }
}
