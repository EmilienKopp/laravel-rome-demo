<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(file_get_contents(database_path('views/2026_06_21_075313_demo_report.sql')));
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS demo_report_view');
    }
};