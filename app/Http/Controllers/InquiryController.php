<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class InquiryController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $inquiries = Inquiry::orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $inquiries,
                'message' => 'Inquiries retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Failed to retrieve inquiries: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve inquiries',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate incoming data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'category' => 'required|in:trading,market_data,technical_issues,general',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:5000',
            ]);

            // Start database transaction
            DB::beginTransaction();

            // Create the inquiry
            $inquiry = Inquiry::create($validated);

            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $inquiry,
                'message' => 'Inquiry submitted successfully'
            ], 201);

        } catch (ValidationException $e) {
            // Validation failed
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            Log::error('Failed to create inquiry: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create inquiry',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show(string $id): JsonResponse
    {
        try {
            $inquiry = Inquiry::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $inquiry,
                'message' => 'Inquiry retrieved successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Inquiry not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve inquiry: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve inquiry',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}