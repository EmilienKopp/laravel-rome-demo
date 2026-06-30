<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(file_get_contents(database_path('views/2026_06_30_000006_active_subscription_usage.sql')));
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS active_subscription_usage');
    }
};
