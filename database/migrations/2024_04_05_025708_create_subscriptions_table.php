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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('user_id');

            $table->index('author_id', 'subscriptions_author_idx');
            $table->index('user_id', 'subscriptions_user_idx');

            $table->foreign('author_id', 'subscriptions_author_fk')
                ->on('users')->references('id');
            $table->foreign('user_id', 'subscriptions_user_fk')
                ->on('users')->references('id');

            $table->unique(['user_id', 'author_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
