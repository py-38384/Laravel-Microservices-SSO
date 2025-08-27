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
       Schema::create('users', function (Blueprint $table) {
           $table->id();
           $table->string('first_name');
           $table->string('last_name');
           $table->string('email')->unique();
           $table->string('password');
           $table->string('email_verified_at')->nullable();
           $table->string('pricing_plan_id')->nullable();
           $table->string('organization')->nullable();
           $table->string('organization_size')->nullable();
           $table->boolean('is_agency')->default(false);
           $table->string('country')->nullable();
           $table->string('time_zone')->nullable();
           $table->string('interest_type')->nullable();
           $table->json('interests')->nullable();


           $table->timestamps();
       });


       // Schema::create('password_reset_tokens', function (Blueprint $table) {
       //     $table->string('email')->primary();
       //     $table->string('token');
       //     $table->timestamp('created_at')->nullable();
       // });


       // Schema::create('sessions', function (Blueprint $table) {
       //     $table->string('id')->primary();
       //     $table->foreignId('user_id')->nullable()->index();
       //     $table->string('ip_address', 45)->nullable();
       //     $table->text('user_agent')->nullable();
       //     $table->longText('payload');
       //     $table->integer('last_activity')->index();
       // });
   }


   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
       Schema::dropIfExists('users');
       // Schema::dropIfExists('password_reset_tokens');
       // Schema::dropIfExists('sessions');
   }
};
