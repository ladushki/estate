<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignId('property_type_id');
            $table->string('county');
            $table->string('country');
            $table->string('town');
            $table->string('postcode')->nullable();
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('image_full')->nullable();
            $table->string('image_thumbnail')->nullable();
            $table->decimal('latitude',10,6);
            $table->decimal('longitude',10,6);
            $table->integer('num_bedrooms');
            $table->integer('num_bathrooms');
            $table->integer('price');
            $table->enum('type', ['sale', 'rent'])->index();
            $table->dateTime('last_modified');
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('is_locked')->default(0);
            $table->softDeletes();
            $table->foreign('property_type_id')->references('id')->on('property_types');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
