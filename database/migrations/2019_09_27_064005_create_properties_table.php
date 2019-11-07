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
            $table->bigIncrements('id');
            $table->string("title");
            $table->text("description");
            $table->integer("bedroom");
            $table->integer("bathroom");
            $table->integer("property_type")->unsigned();
            $table->integer("status_id")->unsigned();
            $table->boolean("for_sale");
            $table->boolean("for_rent");
            $table->integer("project_id")->unsigned();
            $table->integer("region_id")->unsigned();
            $table->timestamps();
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->foreign("property_type")->references("id")->on("property_types");
            $table->foreign("status_id")->references("id")->on("statuses");
            $table->foreign("project_id")->references("id")->on("projects");
            $table->foreign("region_id")->references("id")->on("regions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign('properties_property_type_foreign');
            $table->dropForeign('properties_status_id_foreign');
            $table->dropForeign('properties_project_id_foreign');
            $table->dropForeign('properties_region_id_foreign');
        });
        Schema::dropIfExists('properties');
    }
}
