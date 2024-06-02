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
        Schema::create('company_contacts', function (Blueprint $table) {
            $table->id();

            //Foreign Key referencing 'company_infos' table
            $table->unsignedBigInteger('company_info_fk')->default(0);

            //Relationship
            $table->foreign('company_info_fk')->references('id')->on('company_infos')
            ->restrictOnDelete()
            ->cascadeOnUpdate();
            
            $table->string('name')->nullable(false);
            $table->string('designation')->nullable();
            $table->string('contact_number')->nullable(false);
            $table->string('email_id')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_contacts');
    }
};
