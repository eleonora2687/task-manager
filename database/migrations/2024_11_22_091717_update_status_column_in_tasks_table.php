<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending')->change();
    });
}

public function down()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->string('status')->change(); // You can revert this to a string if needed
    });
}

};
