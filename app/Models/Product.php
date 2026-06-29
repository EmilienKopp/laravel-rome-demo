<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Splitstack\Rome\Concerns\HasReadOnlyMode;

class Product extends Model
{
    use HasReadOnlyMode;

    protected $fillable = ['name', 'price', 'active', 'category_id'];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
