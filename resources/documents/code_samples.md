# Code Samples — ORM vs View

## We've all written something like this

At some point the ORM stops doing what you want. So you reach for `join()`. Then the join isn't enough so you add `selectRaw()`. Then you need a condition on the join so you add `whereRaw()`. Then the aggregation doesn't work so you add `groupByRaw()`.

```php
// "just a quick query"
Subscription::query()
    ->join('tenants', 'tenants.id', '=', 'subscriptions.tenant_id')
    ->whereRaw('subscriptions.cancelled_at IS NULL')
    ->selectRaw('subscriptions.*, tenants.name as tenant_name, COALESCE(SUM(usage_records.quantity), 0) as total_usage')
    ->leftJoin('usage_records', 'usage_records.subscription_id', '=', 'subscriptions.id')
    ->groupByRaw('subscriptions.id, tenants.name')
    ->get();
```

At this point you're writing SQL. You're just writing it badly — scattered across PHP method chains, impossible to reuse outside the app, invisible to anything that isn't Laravel.

**If you're already writing SQL, own it. Write SQL.**

---

## The full scenario

Fetch active subscriptions with their tenant, plan details, and usage stats for the current billing period. A realistic read concern that touches several normalized tables.

---

## Laravel Eloquent — the repository method

```php
class SubscriptionRepository
{
    public function getActiveSubscriptionsWithUsage(): Collection
    {
        return Subscription::query()
            ->with([
                'tenant',
                'plan',
                'plan.features',
            ])
            ->join('tenants', 'tenants.id', '=', 'subscriptions.tenant_id')
            ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
            ->join('billing_periods', function ($join) {
                $join->on('billing_periods.subscription_id', '=', 'subscriptions.id')
                     ->where('billing_periods.is_current', true);
            })
            ->leftJoin('usage_records', function ($join) {
                $join->on('usage_records.billing_period_id', '=', 'billing_periods.id');
            })
            ->where('subscriptions.status', 'active')
            ->where('tenants.is_active', true)
            ->whereNull('subscriptions.cancelled_at')
            ->select([
                'subscriptions.id',
                'subscriptions.status',
                'subscriptions.current_period_ends_at',
                'tenants.id as tenant_id',
                'tenants.name as tenant_name',
                'tenants.slug as tenant_slug',
                'plans.id as plan_id',
                'plans.name as plan_name',
                'plans.price_monthly',
                'billing_periods.id as billing_period_id',
                'billing_periods.started_at',
                'billing_periods.ends_at',
            ])
            ->selectRaw('COALESCE(SUM(usage_records.quantity), 0) as total_usage')
            ->groupBy([
                'subscriptions.id',
                'subscriptions.status',
                'subscriptions.current_period_ends_at',
                'tenants.id',
                'tenants.name',
                'tenants.slug',
                'plans.id',
                'plans.name',
                'plans.price_monthly',
                'billing_periods.id',
                'billing_periods.started_at',
                'billing_periods.ends_at',
            ])
            ->get();
    }
}
```

---

## CakePHP — the equivalent

```php
class SubscriptionsTable extends Table
{
    public function findActiveWithUsage(SelectQuery $query): SelectQuery
    {
        return $query
            ->select([
                'Subscriptions.id',
                'Subscriptions.status',
                'Subscriptions.current_period_ends_at',
                'Tenants.id',
                'Tenants.name',
                'Tenants.slug',
                'Plans.id',
                'Plans.name',
                'Plans.price_monthly',
                'BillingPeriods.id',
                'BillingPeriods.started_at',
                'BillingPeriods.ends_at',
                'total_usage' => $query->func()->coalesce([
                    $query->func()->sum('UsageRecords.quantity'),
                    0,
                ]),
            ])
            ->join([
                'Tenants' => [
                    'table' => 'tenants',
                    'type' => 'INNER',
                    'conditions' => 'Tenants.id = Subscriptions.tenant_id',
                ],
                'Plans' => [
                    'table' => 'plans',
                    'type' => 'INNER',
                    'conditions' => 'Plans.id = Subscriptions.plan_id',
                ],
                'BillingPeriods' => [
                    'table' => 'billing_periods',
                    'type' => 'INNER',
                    'conditions' => [
                        'BillingPeriods.subscription_id = Subscriptions.id',
                        'BillingPeriods.is_current' => true,
                    ],
                ],
                'UsageRecords' => [
                    'table' => 'usage_records',
                    'type' => 'LEFT',
                    'conditions' => 'UsageRecords.billing_period_id = BillingPeriods.id',
                ],
            ])
            ->where([
                'Subscriptions.status' => 'active',
                'Tenants.is_active' => true,
                'Subscriptions.cancelled_at IS' => null,
            ])
            ->groupBy([
                'Subscriptions.id',
                'Subscriptions.status',
                'Subscriptions.current_period_ends_at',
                'Tenants.id',
                'Tenants.name',
                'Tenants.slug',
                'Plans.id',
                'Plans.name',
                'Plans.price_monthly',
                'BillingPeriods.id',
                'BillingPeriods.started_at',
                'BillingPeriods.ends_at',
            ])
            ->contain(['Tenants', 'Plans']);
    }
}
```

---

## The view — same thing, written once in SQL

```sql
CREATE VIEW active_subscriptions_with_usage AS
SELECT
    s.id,
    s.status,
    s.current_period_ends_at,
    t.id               AS tenant_id,
    t.name             AS tenant_name,
    t.slug             AS tenant_slug,
    p.id               AS plan_id,
    p.name             AS plan_name,
    p.price_monthly,
    bp.id              AS billing_period_id,
    bp.started_at,
    bp.ends_at,
    COALESCE(SUM(ur.quantity), 0) AS total_usage
FROM subscriptions s
INNER JOIN tenants t        ON t.id = s.tenant_id
INNER JOIN plans p          ON p.id = s.plan_id
INNER JOIN billing_periods bp
    ON bp.subscription_id = s.id
    AND bp.is_current = true
LEFT JOIN usage_records ur  ON ur.billing_period_id = bp.id
WHERE s.status = 'active'
  AND t.is_active = true
  AND s.cancelled_at IS NULL
GROUP BY
    s.id, s.status, s.current_period_ends_at,
    t.id, t.name, t.slug,
    p.id, p.name, p.price_monthly,
    bp.id, bp.started_at, bp.ends_at;
```

---

## Consuming the view — Laravel

```php
// The repository becomes trivial
class SubscriptionRepository
{
    public function getActiveSubscriptionsWithUsage(): Collection
    {
        return ActiveSubscriptionWithUsage::all();
    }

    public function getForTenant(int $tenantId): Collection
    {
        return ActiveSubscriptionWithUsage::where('tenant_id', $tenantId)->get();
    }
}

// The model is just a pointer
class ActiveSubscriptionWithUsage extends Model
{
    protected $table = 'active_subscriptions_with_usage';
    public $timestamps = false;
}
```

---

## Consuming the view — CakePHP

```php
// Table class is a pointer
class ActiveSubscriptionsWithUsageTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('active_subscriptions_with_usage');
    }
}

// Usage anywhere in the app
$activeSubscriptions = $this->fetchTable('ActiveSubscriptionsWithUsage')
    ->find()
    ->where(['tenant_id' => $tenantId])
    ->all();
```

---

## The point

The SQL in the view is exactly the logic that was in the repository. It didn't move to "the database" — it moved to the right layer of the persistence infrastructure, where it can be named, reused, and consumed by anything that speaks SQL.

The repository didn't disappear. It got simpler.
And the view can now be queried directly by Metabase, Grafana, a dbt pipeline, or PostgREST — without any of them knowing or caring that a Laravel app exists.
