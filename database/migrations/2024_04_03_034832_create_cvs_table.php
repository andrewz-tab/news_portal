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
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->enum('status', ['unverified','approved', 'refused'])
                ->default('unverified');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->index('admin_id', 'cvs_admin_idx');
            $table->index('user_id', 'cvs_user_idx');

            $table->foreign('admin_id', 'cvs_admin_fk')
                ->on('users')->references('id');
            $table->foreign('user_id', 'cvs_user_fk')
                ->on('users')->references('id');

            $table->unique('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
