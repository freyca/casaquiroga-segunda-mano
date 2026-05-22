<?php

declare(strict_types=1);

use App\Models\Issue;
use App\Models\SecondHandMachine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->removeOldNotesKeys();

        // Create the new polymorphic notes table
        Schema::create('notes', function (Blueprint $table): void {
            $table->id();
            $table->text('description');
            $table->foreignId('user_id')->constrained('users');
            $table->morphs('noteable');
            $table->string('previous_state');
            $table->string('new_state');
            $table->timestamps();
        });

        $this->migrateOldNotes();

        Schema::dropIfExists('issue_notes');
        Schema::dropIfExists('second_hand_machine_notes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }

    private function removeOldNotesKeys(): void
    {
        if (Schema::hasTable('issue_notes')) {
            Schema::table('issue_notes', function (Blueprint $table): void {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['issue_id']);
            });
        }

        if (Schema::hasTable('second_hand_machine_notes')) {
            // Sqlite fails, but is only used for testing
            if (DB::getDriverName() !== 'sqlite') {
                // Keys has to be removed like this because laravel prefixes keys with the table name
                // and the foreign keys are prefixed as "notes"
                DB::statement('ALTER TABLE `second_hand_machine_notes` DROP FOREIGN KEY `notes_user_id_foreign`');
                DB::statement('ALTER TABLE `second_hand_machine_notes` DROP FOREIGN KEY `notes_second_hand_machine_id_foreign`');
            } else {
                Schema::dropIfExists('second_hand_machine_notes');
            }
        }
    }

    private function migrateOldNotes(): void
    {
        if (Schema::hasTable('issue_notes')) {
            $issueNotes = DB::table('issue_notes')->get();
            foreach ($issueNotes as $note) {
                DB::table('notes')->insert([
                    'description' => $note->description,
                    'user_id' => $note->user_id,
                    'noteable_id' => $note->issue_id,
                    'noteable_type' => Issue::class,
                    'previous_state' => $note->previous_state,
                    'new_state' => $note->new_state,
                    'created_at' => $note->created_at,
                    'updated_at' => $note->updated_at,
                ]);
            }
        }

        if (Schema::hasTable('second_hand_machine_notes')) {
            $shmNotes = DB::table('second_hand_machine_notes')->get();
            foreach ($shmNotes as $note) {
                DB::table('notes')->insert([
                    'description' => $note->description,
                    'user_id' => $note->user_id,
                    'noteable_id' => $note->second_hand_machine_id,
                    'noteable_type' => SecondHandMachine::class,
                    'previous_state' => $note->previous_state,
                    'new_state' => $note->new_state,
                    'created_at' => $note->created_at,
                    'updated_at' => $note->updated_at,
                ]);
            }
        }
    }
};
