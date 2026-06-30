<?php

namespace Database\Seeders;

use App\Models\BillingPeriod;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class SubscriptionDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Tenants ------------------------------------------------------------
        $acme     = Tenant::create(['name' => 'Acme']);
        $fortyTwo = Tenant::create(['name' => '42 Inc']);
        $umbrella = Tenant::create(['name' => 'Umbrella']);
        $fireship = Tenant::create(['name' => 'fireship.io']);
        $laravel  = Tenant::create(['name' => 'Laravel Inc']);

        // Plans (monthly_quota = included units / month) ---------------------
        $starter = Plan::create(['name' => 'Starter', 'monthly_quota' => 1_000,   'price' => 29.00]);
        $growth  = Plan::create(['name' => 'Growth',  'monthly_quota' => 10_000,  'price' => 99.00]);
        $scale   = Plan::create(['name' => 'Scale',   'monthly_quota' => 100_000, 'price' => 499.00]);

        // Subscriptions ------------------------------------------------------
        // Each entry: [tenant, plan, cancelled?, [period usage totals...]].
        // The usage totals are split into a few records per billing period so
        // SUM(usage_records.quantity) lands on a recognizable % of the quota.
        $subscriptions = [
            // Active — usage maps to a clean % of plan quota
            [$acme,     $scale,   false, [44_000, 43_400]],   // ~87% of 100k
            [$fortyTwo, $growth,  false, [9_650]],            // ~97% of 10k (near quota)
            [$umbrella, $starter, false, [1_240]],            // 124% of 1k (OVER quota)
            [$fireship, $growth,  false, [4_200]],            // 42% of 10k
            [$laravel,  $scale,   false, [60_000, 52_300]],   // 112% of 100k (OVER quota)
            [$umbrella, $growth,  false, [6_800]],            // 68% of 10k (second product)

            // Cancelled — must be filtered out by `cancelled_at IS NULL`
            [$acme,     $growth,  true,  [8_100]],            // upgraded away from Growth
            [$fortyTwo, $starter, true,  [950]],              // upgraded away from Starter
        ];

        foreach ($subscriptions as [$tenant, $plan, $cancelled, $periodTotals]) {
            $subscription = Subscription::create([
                'tenant_id'    => $tenant->id,
                'plan_id'      => $plan->id,
                'started_at'   => now()->subMonths(count($periodTotals)),
                'cancelled_at' => $cancelled ? now()->subDays(10) : null,
            ]);

            foreach ($periodTotals as $offset => $total) {
                // Most recent period first; offset 0 = current month.
                $period = $subscription->billingPeriods()->create([
                    'period_start' => now()->subMonths($offset)->startOfMonth(),
                    'period_end'   => now()->subMonths($offset)->endOfMonth(),
                ]);

                $this->seedUsage($period, $total);
            }
        }
    }

    /**
     * Split a period total into a handful of usage records.
     */
    private function seedUsage(BillingPeriod $period, int $total): void
    {
        // Three records that add up to $total, weighted to look organic.
        $first  = (int) round($total * 0.5);
        $second = (int) round($total * 0.3);
        $third  = $total - $first - $second;

        $period->usageRecords()->createMany([
            ['metric' => 'api_calls', 'quantity' => $first,  'recorded_at' => $period->period_start->copy()->addDays(3)],
            ['metric' => 'api_calls', 'quantity' => $second, 'recorded_at' => $period->period_start->copy()->addDays(12)],
            ['metric' => 'api_calls', 'quantity' => $third,  'recorded_at' => $period->period_start->copy()->addDays(21)],
        ]);
    }
}
