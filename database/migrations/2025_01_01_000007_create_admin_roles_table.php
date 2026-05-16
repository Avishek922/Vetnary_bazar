<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
           // $table->foreignId('user_id')->constrained()->onDelete('cascade');
           $table->unsignedBigInteger('user_id');
            $table->string('role_type'); // e.g., 'super_admin' - redundant with user.role but useful for specific permissions sets if needed
            $table->json('permissions')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_roles');
    }
};
