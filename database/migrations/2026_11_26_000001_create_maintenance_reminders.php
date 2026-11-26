<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->unsignedInteger('odometer_km')->nullable();
        });

        Schema::create('maintenance_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->string('title', 150);
            $table->date('due_on')->nullable();
            $table->unsignedInteger('due_odometer_km')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['car_id', 'completed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_reminders');
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('odometer_km');
        });
    }
};
