<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryController;

// Health check route (optional - helps verify API is working)
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is running',
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Inquiry routes
Route::prefix('inquiries')->group(function () {
    // GET /api/inquiries - List all inquiries
    Route::get('/', [InquiryController::class, 'index']);
    
    // POST /api/inquiries - Create new inquiry
    Route::post('/', [InquiryController::class, 'store']);
    
    // GET /api/inquiries/{id} - Get specific inquiry
    Route::get('/{id}', [InquiryController::class, 'show']);
});