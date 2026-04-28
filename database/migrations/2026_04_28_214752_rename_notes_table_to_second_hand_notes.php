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
        Schema::rename('notes', 'second_hand_notes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('second_hand_notes', 'notes');
    }
};
