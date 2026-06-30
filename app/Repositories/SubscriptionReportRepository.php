<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * The "before" picture: the active-subscriptions-with-usage report assembled by
 * hand. Every join, every grouped column and every aggregate lives here, and any
 * caller that wants this data has to either call this method or copy/paste the
 * whole thing. This is the SQL sprawl / join hell the slides talk about.
 */
class SubscriptionReportRepository
{
    public function getActiveSubscriptionsWithUsage(): Collection
    {
        return DB::table('subscriptions')
            ->join('tenants', 'tenants.id', '=', 'subscriptions.tenant_id')
            ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
            ->leftJoin('billing_periods', 'billing_periods.subscription_id', '=', 'subscriptions.id')
            ->leftJoin('usage_records', 'usage_records.billing_period_id', '=', 'billing_periods.id')
            ->whereNull('subscriptions.cancelled_at')
            ->groupBy(
                'subscriptions.id',
                'subscriptions.tenant_id',
                'subscriptions.plan_id',
                'subscriptions.started_at',
                'tenants.name',
                'plans.name',
                'plans.monthly_quota',
                'plans.price',
            )
            ->selectRaw('subscriptions.id')
            ->selectRaw('subscriptions.tenant_id')
            ->selectRaw('subscriptions.plan_id')
            ->selectRaw('tenants.name as tenant_name')
            ->selectRaw('plans.name as plan_name')
            ->selectRaw('plans.monthly_quota')
            ->selectRaw('plans.price')
            ->selectRaw('subscriptions.started_at')
            ->selectRaw('COALESCE(SUM(usage_records.quantity), 0) as total_usage')
            ->selectRaw('ROUND(COALESCE(SUM(usage_records.quantity), 0) * 100.0 / plans.monthly_quota, 1) as usage_pct')
            ->selectRaw('(COALESCE(SUM(usage_records.quantity), 0) > plans.monthly_quota) as over_quota')
            ->orderByDesc('total_usage')
            ->get();
    }
}
