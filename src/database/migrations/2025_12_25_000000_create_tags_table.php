<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id');
            $table->string('name');
            $table->string('color', 7)->default('#3b82f6'); // Hex color code
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unique(['tenant_id', 'name']); // Unique name per tenant
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
