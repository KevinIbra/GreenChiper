<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dataset_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('dataset_name');
            $table->string('method');
            $table->float('psnr');
            $table->float('ssim');
            $table->float('processing_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dataset_metrics');
    }
};