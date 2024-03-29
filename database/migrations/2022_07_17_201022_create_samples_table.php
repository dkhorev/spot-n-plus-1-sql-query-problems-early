<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('samples', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->float('temp');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
