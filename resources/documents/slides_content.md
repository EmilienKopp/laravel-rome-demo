# Stop being scared of your database — Slide Content

> Extracted from `resources/js/Pages/slides/`, in presentation order.
> Code snippets show the **final** state (after all transitions complete).

---

## 1. Title

# Stop being **scared** of your database

Views aren't dangerous. They were just **invisible**.

---

## 2. Just one little sort (FlattenToSort)

# Just one little **sort**

```php
// …or reach for joins, just to ORDER BY.
Subscription::query()
    ->leftJoin('billing_periods', /* ... */)
    ->leftJoin('usage_records', /* ... */)
    ->groupBy(/* every selected column */)
    ->orderByRaw('SUM(usage_records.quantity) DESC');
```

---

## 3. The symptoms (Symptoms)

# The **symptoms**

---

## 4. JOIN hell (JoinHell)

# JOIN **hell**

```php
public function getActiveSubscriptionsWithUsage()
{
    return Subscription::query()
        ->join('tenants', /* ... */)
        ->join('plans', /* ... */)
        ->join('billing_periods', /* ... */)
        ->leftJoin('usage_records', /* ... */)
        ->select([/* 12 columns */])
        ->selectRaw('SUM(usage_records.quantity) as total')
        ->groupBy([/* same 12 columns */])
        ->get();
}
```

---

## 5. SQL sprawl (SqlSprawl)

# SQL **sprawl**

```php
Subscription::query()
    ->join('tenants', /* tenant_id */)
    ->leftJoin('usage_records', /* ... */)
    ->selectRaw('SUM(usage_records.quantity) as usage')
    ->whereRaw('subscriptions.cancelled_at IS NULL')
    ->groupByRaw('subscriptions.id, tenants.name')
    ->get();
```

You're already writing SQL. Just **wrapped**.

---

## 6. Database views fix every one of these (ViewsFixThis)

# Database **views**

fix every one of these.

---

## 7. What is a view? (ViewExample)

# What is a **view**?

---

## 8. A view is a read repository (WhatIsAView)

# A view is a **read repository**.

Written in SQL.

---

## 9. Composability (Composability)

# One **definition**.

Consumed everywhere.

Inside your app...

... and in PostgREST · Metabase · Grafana · dbt ...

Your app and your BI tools **read the same thing**.

---

## 10. So why don't we use database views more? (WhyNotViews)

# So why don't we use **database views** more?

---

## 11. The Stigma (Stigma)

# The **Stigma**

_"No logic in the DB"_

A legitimate rule — aimed at the wrong target.

---

## 12. Opinion vs. Reality (OpinionVsReality)

**The reality** (final phase)

| | | |
|---|---|---|
| Triggers | → | 💥 side effects, invisible mutations |
| Stored procedures | → | 💥 hidden behavior, split logic |
| DB views | → | ✅ **just a query with a name** |

---

## 13. Write it once (WriteItOnce)

# Write it **once**

```sql
CREATE VIEW active_subscriptions_with_usage AS
SELECT s.*, t.name AS tenant_name,
       COALESCE(SUM(ur.quantity), 0) AS total_usage
FROM subscriptions s
JOIN tenants t            ON t.id = s.tenant_id
LEFT JOIN usage_records ur ON ur.subscription_id = s.id
WHERE s.cancelled_at IS NULL
GROUP BY s.id, t.name;
```

The exact same logic. Named. Reusable.

---

## 14. The repository shrinks (RepositoryShrinks)

# The repository **shrinks**

```php
class ActiveSubscriptionWithUsage extends Model
{
    protected $table = 'active_subscriptions_with_usage';
}

ActiveSubscriptionWithUsage::all();
```

The model is just a pointer.

---

## 15. Flat. Sortable. Paginated. (FlatAndSortable)

# Flat. **Sortable**. Paginated.

```php
ActiveSubscriptionUsage::query()
    ->orderByDesc('total_usage') // ✅ just a column
    ->paginate(20);
```

The sort we couldn't write — now trivial.

---

## 16. But it's still a Model (WriteSafety)

# But it's still a **Model**

```php
class ActiveSubscriptionUsage extends Model
{
    protected $table = 'active_subscription_usage';
}

$row = ActiveSubscriptionUsage::first();
$row->update(['price' => 42]); // 💥 error here... or a silent write
```

Simple views are **updatable** — the DB won't always stop you. So enforce it in the model.

---

## 17. What we need (WhatWeNeed)

# What we **need**

First-class **citizenship**.

- › Preconfigured **read-only** model
- › **Proxy** ergonomics — read & write as one object with two targets
- › Easy, timestamped **scaffolding** of views & migrations — `make:dbview`
- › Easy view regeneration, **multitenancy-proof** — `dbview:regen --tenants acme,laravel,fireship`

```php
use Splitstack\Rome\Models\ReadOnlyModel;

class ActiveSubscriptionUsage extends ReadOnlyModel
{
    protected $table = 'active_subscription_usage';
    protected $proxyTo = 'App\Models\Subscription';
}

$row = ActiveSubscriptionUsage::first();
$row->update(['price' => 42]); // ❌ ReadOnlyModelException
$row->proxied()->update(['price' => 42]); // EXPLICIT proxied update works
ActiveSubscriptionUsage::orderBy('computed_column')
    ->paginate(); // Still easy, flat, sortable, and paginatable
```

---

## 18. The fix (Fix)

# DB views aren't **dangerous**.

They just used to be **invisible**.

**Not anymore.**

### laravel-**rome**

`github.com/EmilienKopp/laravel-rome`

- › View-aware Eloquent models — read-only, write-back proxy
- › `make:dbview` / `dbview:regen` — scaffold & regenerate views
- › PHPStan rules — catch misuse at build time

---

## 19. Thank you (ThankYou)

🙏

# Thank **you**.

Built with **Laravel** · **Inertia** · **Svelte** — slides powered by **Animotion**.

### laravel-**rome**

`github.com/EmilienKopp/laravel-rome`

- › View-aware Eloquent models — read-only, write-back proxy
- › `make:dbview` / `dbview:regen` — scaffold & regenerate views
- › PHPStan rules — catch misuse at build time
