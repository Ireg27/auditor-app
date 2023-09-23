<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleJobRequest;
use App\Http\Resources\ScheduleJobResource;
use App\Models\ScheduleJob;

class ScheduleJobController extends Controller
{
    public function index()
    {
        return ScheduleJobResource::collection(ScheduleJob::all());
    }

    public function store(ScheduleJobRequest $request)
    {
        return new ScheduleJobResource(ScheduleJob::create($request->validated()));
    }

    public function show(ScheduleJob $scheduleJob)
    {
        return new ScheduleJobResource($scheduleJob);
    }

    public function update(ScheduleJobRequest $request, ScheduleJob $scheduleJob)
    {
        $scheduleJob->update($request->validated());

        return new ScheduleJobResource($scheduleJob);
    }

    public function destroy(ScheduleJob $scheduleJob)
    {
        $scheduleJob->delete();

        return response()->json();
    }
}
