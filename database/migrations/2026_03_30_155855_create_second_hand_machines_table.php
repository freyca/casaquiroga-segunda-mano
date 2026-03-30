<?php

declare(strict_types=1);

use App\Enums\Status;
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
        Schema::create('second_hand_machines', function (Blueprint $table) {
            $table->id();

            $table->string('codigo')->unique();
            $table->string('nombre');

            // Purchase info
            $table->decimal('coste', 10, 2)->nullable();
            $table->foreignId('responsable_compra_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('cliente_compra_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('observaciones_compra')->nullable();

            // Machine details
            $table->foreignId('family_id')->nullable()->constrained('families')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable()->unique();

            // Sale info
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->decimal('taller_reparacion', 10, 2)->nullable();
            $table->tinyInteger('tax')->default(Tax::Zero->value);

            // Extra
            $table->integer('horas_trabajo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('estado')->default(Status::Disponible->value);

            // Files
            $table->json('fotos')->nullable();
            $table->json('adjuntos')->nullable();

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
