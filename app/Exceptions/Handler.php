<?php

public function register(): void
{

    $this->renderable(function (\Exception $e, $request) {
        if ($request->is('api/*')) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Database error occurred',
                    'error' => config('app.debug') ? $e->getMessage() : 'Service temporarily unavailable'
                ], 500);
            }

            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found'
                ], 404);
            }

            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    });
}