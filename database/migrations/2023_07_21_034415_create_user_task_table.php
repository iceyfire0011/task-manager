<?php

use App\Models\task\Task;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(User::class, 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('task_id')->constrained(Task::class, 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_notified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_task');
    }
};
