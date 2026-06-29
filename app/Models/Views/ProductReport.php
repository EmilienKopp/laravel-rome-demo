<?php

namespace App\Models\Views;

use App\Models\Product;
use Splitstack\Rome\Models\ReadOnlyModel;

class ProductReport extends ReadOnlyModel
{
    protected $table = 'product_report_view';

    protected $fillable = ['name', 'price', 'active', 'category_id'];

    // Computed columns that don't exist on the products table — exclude them
    // so proxy() / update() don't try to write them.
    protected static array $exclude = ['category_name', 'price_with_tax', 'product_name'];

    protected static $proxyTo = Product::class;

    public $timestamps = false;

    protected $casts = [
        'price' => 'decimal:2',
        'price_with_tax' => 'decimal:2',
        'active' => 'boolean',
    ];
}
