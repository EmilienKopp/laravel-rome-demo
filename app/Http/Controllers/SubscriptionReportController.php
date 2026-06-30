<?php

namespace App\Http\Controllers;

use App\Models\Views\ActiveSubscriptionUsage;
use App\Repositories\SubscriptionReportRepository;
use Illuminate\Http\JsonResponse;

class SubscriptionReportController extends Controller
{
    /**
     * The hand-rolled way: join hell hidden in a repository method.
     */
    public function bad(SubscriptionReportRepository $repository): JsonResponse
    {
        return response()->json($repository->getActiveSubscriptionsWithUsage());
    }

    /**
     * The Rome way: a read-only model over a named database view. Same result,
     * one clean Eloquent query.
     */
    public function clean(): JsonResponse
    {
        return response()->json(
            ActiveSubscriptionUsage::query()
                ->orderByDesc('total_usage')
                ->get()
        );
    }
}
