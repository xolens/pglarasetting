<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Xolens\Larasetting\App\Util\LarasettingMigration;

class LarasettingCreateRemoveIdentifiableTriggerFunction extends LarasettingMigration
{
    /**
     * Return table name
     *
     * @return string
     */
    public static function tableName(){
        return 'remove_identifiable_trigger_function';
    }
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE FUNCTION ".self::table()."() RETURNS trigger
            LANGUAGE plpgsql AS $$
                BEGIN
                    PERFORM ".LarasettingCreateRemoveIdentifiableFunction::table()."(TD['args'][0]);
                    RETURN NULL;
                END;
            $$;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            DROP FUNCTION IF EXISTS ".self::table()."() CASCADE;
        ");
    }
}
