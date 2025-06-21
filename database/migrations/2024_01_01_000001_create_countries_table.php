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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('iso_alpha2', 2)->unique()->index();
            $table->string('iso_alpha3', 3)->unique()->index();
            $table->string('iso_numeric', 3)->nullable()->index();
            $table->string('phone_code', 10)->index();
            $table->string('flag_emoji', 10)->nullable();
            $table->string('continent', 50)->index();
            $table->string('region', 100)->index();
            $table->string('sub_region', 100)->nullable();
            $table->string('capital', 100)->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->string('currency_name', 100)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->json('languages')->nullable();
            $table->bigInteger('population')->nullable();
            $table->decimal('area_km2', 15, 2)->nullable();
            $table->decimal('gdp_usd', 20, 2)->nullable();
            $table->string('internet_tld', 10)->nullable();
            $table->enum('driving_side', ['left', 'right'])->nullable();
            $table->string('calling_code', 10)->nullable();
            $table->string('postal_code_format', 100)->nullable();
            $table->string('postal_code_regex', 255)->nullable();
            $table->string('geonames_id', 20)->nullable();
            $table->string('fips_code', 10)->nullable();
            $table->boolean('un_member')->default(false);
            $table->boolean('independent')->default(true);
            $table->enum('status', ['active', 'inactive', 'disputed'])->default('active');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['continent', 'region']);
            $table->index(['phone_code', 'status']);
            $table->index(['un_member', 'independent']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
}; 