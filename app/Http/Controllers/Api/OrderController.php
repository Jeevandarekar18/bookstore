<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = max(1, (int) $request->input('per_page', 10));

        $query = Order::with(['user', 'orderItems.book']);

        // Filter by user unless admin
        if ($request->user() && ! $request->user()->is_admin) {
            $query->where('user_id', $request->user()->id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate($perPage)->appends($request->query());

        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'sometimes|in:pending,processing,shipped,delivered,cancelled',
            'order_date' => 'required|date',
            'order_items' => 'required|array',
            'order_items.*.book_id' => 'required|exists:books,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
        ]);

        if ($user && (int) $validated['user_id'] !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $order = Order::create($validated);

        foreach ($validated['order_items'] as $item) {
            $order->orderItems()->create($item);
        }

        return response()->json($order->load(['user', 'orderItems.book']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResponse
    {
        Gate::authorize('view', $order);

        return response()->json($order->load(['user', 'orderItems.book']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        Gate::authorize('update', $order);

        $validated = $request->validate([
            'status' => 'sometimes|in:pending,processing,shipped,delivered,cancelled,deny',
        ]);

        if (isset($validated['status']) && $validated['status'] === 'deny') {
            $validated['status'] = 'cancelled';
        }

        $order->update($validated);

        return response()->json($order->load(['user', 'orderItems.book']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse
    {
        Gate::authorize('delete', $order);

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
