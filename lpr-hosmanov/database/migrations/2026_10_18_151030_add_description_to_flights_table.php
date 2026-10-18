<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('flights', function (Blueprint $table) {
        $table->text('description')->nullable()->after('number');
        $table->string('number', 154)->change();
    });
}

public function down(): void
{
    Schema::table('flights', function (Blueprint $table) {
        $table->dropColumn('description');
    });

    Schema::table('flights', function (Blueprint $table) {
        $table->string('number', 10)->change();
    });
}
};
