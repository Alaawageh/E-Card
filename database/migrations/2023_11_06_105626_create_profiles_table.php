<?php

use App\Type\ModeType;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nick_name');
            $table->string('theme')->nullable();
            $table->string('color')->nullable();
            $table->string('cover')->nullable();
            $table->string('photo')->nullable();
            $table->string('emails')->nullable();
            $table->json('phoneNum')->nullable();
            $table->text('bio')->nullable();
            $table->text('about')->nullable();
            $table->text('location')->nullable();
            $table->bigInteger('views')->nullable();
            $table->string('mode')->default('light');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
