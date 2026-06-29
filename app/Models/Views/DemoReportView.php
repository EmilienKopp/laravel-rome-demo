<?php

namespace App\Models\Views;

use Splitstack\Rome\Models\ReadOnlyModel;

class DemoReportView extends ReadOnlyModel
{
    protected $table = 'demo_report_view';

    protected $fillable = [
        'name',
        'price',
        'active',
        'category_id',
    ];

    public $timestamps = false;
}
