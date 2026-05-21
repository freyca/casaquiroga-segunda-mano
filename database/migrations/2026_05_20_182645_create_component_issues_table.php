<?php

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
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
        Schema::create('component_issues', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('machine_id')->constrained();

            // Fields
            $table->string('reference_number')->unique();
            $table->string('priority')->default(IssuePriority::STANDARD->value);
            $table->string('status')->default(IssueStatus::CREATED->value);
            $table->longText('description');
            $table->boolean('just_arrived')->default(false);
            $table->json('images')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_issues');
    }
};
