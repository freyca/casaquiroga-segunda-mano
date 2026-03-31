<?php

declare(strict_types=1);

use App\Enums\SellStatus;
use App\Enums\Tax;
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
        Schema::create('second_hand_machines', function (Blueprint $table): void {
            $table->id();

            $table->string('identifier_code')->unique();
            $table->string('name');

            // Purchase info
            $table->decimal('purchase_cost', 10, 2)->nullable();
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('purchase_notes')->nullable();

            // Machine details
            $table->foreignId('family_id')->nullable()->constrained('families')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->unique();

            // Sale info
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->decimal('repair_workshop', 10, 2)->nullable();
            $table->tinyInteger('tax')->default(Tax::Zero->value);

            // Extra
            $table->integer('work_hours')->nullable();
            $table->text('description')->nullable();
            $table->string('sell_status')->default(SellStatus::Available->value);

            // Files
            $table->json('photos')->nullable();
            $table->json('attachments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('second_hand_machines');
    }
};
