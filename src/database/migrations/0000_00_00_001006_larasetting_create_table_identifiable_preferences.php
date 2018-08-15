<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

use Xolens\Larasetting\App\Util\LarasettingMigration;

class LarasettingCreateTableIdentifiablePreferences extends LarasettingMigration
{
    /**
     * Return table name
     *
     * @return string
     */
    public static function tableName(){
        return 'identifiable_preferences';
    }    

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('preference_value')->nullable();
            $table->string('identifiable_type');
            $table->integer('identifiable_id');
          
            $table->integer('id_preference')->index();
            $table->unique(['id_preference', 'identifiable_type', 'identifiable_id']);
        });
        if(self::logEnabled()){
            self::registerForLog();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(self::logEnabled()){
            self::unregisterFromLog();
        }
        Schema::dropIfExists(self::table());

    }
}
