<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function analytics(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $statusBreakdown = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $topCategories = Book::query()
            ->select('categories.name as category_name', DB::raw('count(books.id) as total_books'))
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_books')
            ->limit(5)
            ->get();

        return response()->json([
            'summary' => [
                'books' => Book::count(),
                'orders' => Order::count(),
                'revenue' => (float) Order::whereIn('status', ['shipped', 'delivered'])->sum('total_amount'),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'completed_orders' => Order::whereIn('status', ['shipped', 'delivered'])->count(),
            ],
            'status_breakdown' => $statusBreakdown,
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'top_categories' => $topCategories,
        ]);
    }
}
