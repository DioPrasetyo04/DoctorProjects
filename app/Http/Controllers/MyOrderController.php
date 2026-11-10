<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\BookingTransactionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    private $bookingUserTransactionService;

    public function __construct(BookingTransactionService $bookingTransactionService)
    {
        $this->bookingUserTransactionService = $bookingTransactionService;
    }

    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        $orders = $this->bookingUserTransactionService->getAllForUser($userId);
        return response()->json(TransactionResource::collection($orders), 200);
    }

    public function show(int $id)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $order = $this->bookingUserTransactionService->getById($id, $userId);
            return response()->json(new TransactionResource($order), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    }

    public function store(BookingTransactionRequest $request)
    {
        $transaction = $this->bookingUserTransactionService->create($request->validated());
        $transaction = $this->bookingUserTransactionService->getById($transaction->id, auth()->user()->id);
        return response()->json(new TransactionResource($transaction), 201);
    }
}
