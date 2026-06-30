<?php

namespace App\Models\Views;

use Splitstack\Rome\Models\ReadOnlyModel;

/**
 * The "after" picture: the same join hell, named once in the database view, and
 * queried like any other Eloquent model. Read-only by design — it's a pure
 * aggregate report, so there's nothing to write back (no $proxyTo).
 */
class ActiveSubscriptionUsage extends ReadOnlyModel
{
    protected $table = 'active_subscription_usage';

    public $timestamps = false;

    protected $casts = [
        'monthly_quota' => 'integer',
        'price' => 'decimal:2',
        'total_usage' => 'integer',
        'usage_pct' => 'decimal:1',
        'over_quota' => 'boolean',
        'started_at' => 'datetime',
    ];
}
