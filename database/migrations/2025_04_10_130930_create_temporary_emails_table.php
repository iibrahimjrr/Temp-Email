<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('temporary_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();  
            $table->timestamp('expires_at');         
            $table->timestamps();
        });
    }    

    public function down(): void
    {
        Schema::dropIfExists('temporary_emails');
    }
};
