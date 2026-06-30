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
    Schema::create('committees', function (Blueprint $table) {
        $table->id();

        $table->string('committee_type');

        $table->string('name');

        $table->string('image')->nullable();

        $table->string('club_position');

        $table->string('varsity_position')->nullable();

        $table->string('facebook_link')->nullable();

        $table->string('linkedin_link')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committees');
    }
};
