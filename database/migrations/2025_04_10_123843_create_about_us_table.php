<?php

use App\Models\AboutUs;
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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->default('default.png');
            $table->timestamps();
        });

        AboutUs::create([
            'title' => 'About Us',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit vitae repellat laudantium, quos maxime ducimus? Dolorum blanditiis ratione debitis necessitatibus.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
