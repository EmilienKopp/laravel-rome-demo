CREATE
OR REPLACE VIEW product_report_view AS
SELECT
    p.id,
    p.name AS product_name,
    p.price,
    p.active,
    p.category_id,
    c.name AS category_name,
    ROUND(p.price * 1.2, 2) AS price_with_tax
FROM
    products p
    JOIN categories c ON c.id = p.category_id