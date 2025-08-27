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
       Schema::create('user_social_accounts', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('user_id');
           $table->string('title');
           $table->json('pages'); 
           $table->timestamps();
       });
   }


   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
       Schema::dropIfExists('user_social_accounts');
   }
};
