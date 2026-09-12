<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'salesrep'])->default('salesrep')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('area')->nullable()->after('phone');
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->after('area');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'area', 'status']);
        });
    }
};