<?php

declare(strict_types=1);

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
        Schema::create('issues', function (Blueprint $table): void {
            $table->id();

            // Relations
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('order_id')->constrained();
            $table->foreignId('machine_id')->constrained();

            // Fields
            $table->string('type');
            $table->string('priority')->default(IssuePriority::STANDARD->value);
            $table->string('status')->default(IssueStatus::CREATED->value);
            $table->longText('description');
            $table->boolean('just_arrived')->default(false);
            $table->longText('observations')->nullable();
            $table->json('images')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
