<?php

namespace App\Http\Controllers\Api;

use App\Enums\JobStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleJob\AssignJobRequest;
use App\Http\Requests\ScheduleJob\CompleteJobRequest;
use App\Http\Requests\ScheduleJob\StoreScheduleJobRequest;
use App\Http\Resources\ScheduleJob\ScheduleJobListResource;
use App\Http\Resources\ScheduleJob\ScheduleJobResource;
use App\Models\ScheduleJob;
use Illuminate\Http\JsonResponse;

class ScheduleJobController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Success.',
            'data' => ScheduleJobListResource::collection(ScheduleJob::all()),
        ]);
    }

    public function store(StoreScheduleJobRequest $request): JsonResponse
    {
        ScheduleJob::create($request->validated());

        return response()->json([
            'message' => 'Successfully created a job.',
        ]);
    }

    public function show(ScheduleJob $scheduleJob): JsonResponse
    {
        return response()->json([
            'message' => 'Success.',
            'data' => ScheduleJobResource::make($scheduleJob),
        ]);
    }

    public function assignJob(ScheduleJob $scheduleJob, AssignJobRequest $request): JsonResponse
    {
        if ($scheduleJob->user_id !== null) {
            return response()->json([
                'message' => 'This job already has a person assigned to it.',
            ]);
        }

        $scheduleJob->update([
            'scheduled_date' => $request->validated('date'),
            'user_id' => $request->user()->id,
            'status' => JobStatusEnum::IN_PROGRESS,
        ]);

        return response()->json([
            'message' => 'You assigned yourself to this job.',
        ]);
    }

    public function completeJob(ScheduleJob $scheduleJob, CompleteJobRequest $request): JsonResponse
    {
        if ($scheduleJob->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'You can not complete a job that is not assigned to you.',
            ]);
        }

        $scheduleJob->update([
            'assessment' => $request->validated('assessment'),
            'status' => JobStatusEnum::DONE,
        ]);

        return response()->json([
            'message' => 'You marked this job as done!.',
        ]);
    }
}
