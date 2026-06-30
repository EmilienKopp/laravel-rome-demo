CREATE
OR REPLACE VIEW active_subscription_usage AS
SELECT
    s.id,
    s.tenant_id,
    s.plan_id,
    t.name AS tenant_name,
    p.name AS plan_name,
    p.monthly_quota,
    p.price,
    s.started_at,
    COALESCE(SUM(u.quantity), 0) AS total_usage,
    ROUND(COALESCE(SUM(u.quantity), 0) * 100.0 / p.monthly_quota, 1) AS usage_pct,
    (COALESCE(SUM(u.quantity), 0) > p.monthly_quota) AS over_quota
FROM
    subscriptions s
    JOIN tenants t ON t.id = s.tenant_id
    JOIN plans p ON p.id = s.plan_id
    LEFT JOIN billing_periods bp ON bp.subscription_id = s.id
    LEFT JOIN usage_records u ON u.billing_period_id = bp.id
WHERE
    s.cancelled_at IS NULL
GROUP BY
    s.id,
    s.tenant_id,
    s.plan_id,
    t.name,
    p.name,
    p.monthly_quota,
    p.price,
    s.started_at
