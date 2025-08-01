<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\RegisterEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
     public function index()
    {
        return EventResource::collection(Event::with('participants')->paginate(10));
    }

    public function store(CreateEventRequest $request): JsonResponse
{
    try {
       
        $event = Event::create($request->validated());
        
        Log::info('Event created successfully', [
            'event_id' => $event->id,           
            'data' => $request->validated()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully.',
            'data' => new EventResource($event)
        ], 201);

    } catch (\Exception $e) {
        // Log the error
        Log::error('Failed to create event', [           
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to create event. Please try again later.',
        ], 500);
    }
}

    public function show(Event $event)
    {
        
        return new EventResource($event->load('participants'));
    }

    

    public function register(RegisterEventRequest $request)
    {
        $event = Event::findOrFail($request->event_id);
        
        if ($event->isFull()) {
            return response()->json(['error' => 'Event is full'], 400);
        }

        if ($event->hasOverlap($request->user_id)) {
            return response()->json(['error' => 'Schedule conflict detected'], 400);
        }

        DB::beginTransaction();
        try {
            $event->participants()->attach($request->user_id);
            DB::commit();
            return new EventResource($event->load('participants'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Registration failed'], 500);
        }
    }


    public function cancel(Event $event)
{
    $event->delete();
    return response()->json(['message' => 'Event cancelled successfully']);
}
}
