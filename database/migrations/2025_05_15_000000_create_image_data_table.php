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
        Schema::create('image_data', function (Blueprint $table) {
            $table->id();
            $table->string('original_image');
            $table->string('stego_image');
            $table->text('hidden_message');
            $table->string('method_used');
            $table->float('psnr_value');
            $table->float('ssim_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_data');
    }
};