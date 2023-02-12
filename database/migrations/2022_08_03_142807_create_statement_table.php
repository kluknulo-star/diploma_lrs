<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->uuid('statement_id')->primary();
//            $table->id('statement_id');
            $table->string('agent')
                ->virtualAs('content ->> \'$.actor.mbox\'')->index();
            $table->string('activity')
                ->virtualAs('content ->> \'$.object.id\'')->index();
            $table->string('verb')
                ->virtualAs('content ->> \'$.verb.id\'')->index();
            $table->string('context')
                ->virtualAs('content ->> \'$.context.contextActivities.parent\'');

            $table->json('content');


            $table->string('actor_mbox')->virtualAs('content ->> \'$.actor.mbox\'')->index();
            $table->string('actor_name')->virtualAs('content ->> \'$.actor.name\'')->index();
            $table->string('actor_openid')->virtualAs('content ->> \'$.actor.openid\'')->index();
            $table->string('verb_id')->virtualAs('content ->> \'$.verb.id\'')->index();
            $table->string('object_id')->virtualAs('content ->> \'$.object.id\'')->index();
            $table->string('object_type')->virtualAs('content ->> \'$.object.type\'')->index();
            $table->string('context_id')->virtualAs('content ->> \'$.context.id\'')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statements');
    }
};
