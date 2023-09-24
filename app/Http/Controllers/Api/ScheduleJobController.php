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
    /**
     * @OA\Get(
     *    path="/schedule-jobs",
     *    operationId="index",
     *    tags={"Schedule Jobs"},
     *    summary="Get list of schedule jobs",
     *    description="Get list of schedule jobs",
     *    security={
     *     {"sanctum": {}},
     *    },
     *
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Success.',
            'data' => ScheduleJobListResource::collection(ScheduleJob::all()),
        ]);
    }

    /**
     * @OA\Post(
     *    path="/schedule-jobs",
     *    operationId="store",
     *    tags={"Schedule Jobs"},
     *    summary="Store a new job",
     *    description="Create a new job",
     *    security={
     *     {"sanctum": {}},
     *    },
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *            required={"title", "description"},
     *
     *            @OA\Property(property="title", type="string", format="string", example="New Job"),
     *            @OA\Property(property="description", type="string", format="string", example="New job description"),
     *         ),
     *      ),
     *
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *        response=422,
     *        description="Unprocessable Content",
     *    ),
     * )
     */
    public function store(StoreScheduleJobRequest $request): JsonResponse
    {
        ScheduleJob::create($request->validated());

        return response()->json([
            'message' => 'Successfully created a job.',
        ]);
    }

    /**
     * @OA\Get(
     *    path="/schedule-jobs/{scheduleJob}",
     *    operationId="show",
     *    tags={"Schedule Jobs"},
     *    summary="Get schedule jobs",
     *    description="Get schedule jobs",
     *    security={
     *     {"sanctum": {}},
     *    },
     *
     *      @OA\Parameter(
     *      name="scheduleJob",
     *      in="path",
     *      required=true,
     *
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *      * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  ),
     * )
     */
    public function show(ScheduleJob $scheduleJob): JsonResponse
    {
        return response()->json([
            'message' => 'Success.',
            'data' => ScheduleJobResource::make($scheduleJob),
        ]);
    }

    /**
     * @OA\Patch(
     *    path="/schedule-jobs/{scheduleJob}/assign",
     *    operationId="assignJob",
     *    tags={"Schedule Jobs"},
     *    summary="Assign self to a job",
     *    description="Assign self to a job",
     *    security={
     *     {"sanctum": {}},
     *    },
     *
     *      @OA\Parameter(
     *      name="scheduleJob",
     *      in="path",
     *      required=true,
     *
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *            required={"date"},
     *
     *            @OA\Property(property="date", type="string", format="string", example="2024-01-01"),
     *         ),
     *      ),
     *
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *   @OA\Response(
     *      response=409,
     *      description="Conflict"
     *   ),
     *   @OA\Response(
     *          response=422, description="Unprocessable Content",
     *   )
     *  ),
     * )
     */
    public function assignJob(ScheduleJob $scheduleJob, AssignJobRequest $request): JsonResponse
    {
        if ($scheduleJob->user_id !== null) {
            return response()->json([
                'message' => 'This job already has a person assigned to it.',
            ], 409);
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

    /**
     * @OA\Patch(
     *    path="/schedule-jobs/{scheduleJob}/complete",
     *    operationId="completeJob",
     *    tags={"Schedule Jobs"},
     *    summary="Mark a job as completed",
     *    description="Mark a job as completed",
     *    security={
     *     {"sanctum": {}},
     *    },
     *
     *      @OA\Parameter(
     *      name="scheduleJob",
     *      in="path",
     *      required=true,
     *
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *            required={"assessment"},
     *
     *            @OA\Property(property="assessment", type="string", format="string", example="A note about how the job went."),
     *         ),
     *      ),
     *
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *   @OA\Response(
     *      response=409,
     *      description="Conflict"
     *   ),
     *   @OA\Response(
     *          response=422, description="Unprocessable Content",
     *   )
     *  ),
     * )
     */
    public function completeJob(ScheduleJob $scheduleJob, CompleteJobRequest $request): JsonResponse
    {
        if ($scheduleJob->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'You can not complete a job that is not assigned to you.',
            ], 409);
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
