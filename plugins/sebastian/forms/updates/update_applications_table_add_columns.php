<?php namespace Sebastian\Marketplace\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateApplicationsTableAddColumns extends Migration
{
    /**
     * @var string
     */
    const TABLE_NAME = 'sebastian_forms_applications';

    public function up()
    {
        Schema::table(self::TABLE_NAME, function(Blueprint $table) {
            if (!Schema::hasColumn(self::TABLE_NAME, 'district')) {
                $table->string('district')->nullable();
            }

            if (!Schema::hasColumn(self::TABLE_NAME, 'budget')) {
                $table->string('budget')->nullable();
            }

            if (!Schema::hasColumn(self::TABLE_NAME, 'locatie')) {
                $table->string('locatie')->nullable();
            }

            if (!Schema::hasColumn(self::TABLE_NAME, 'url')) {
                $table->string('url')->nullable();
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            return;
        }

        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            if (Schema::hasColumn(self::TABLE_NAME, 'district')) {
                $table->dropColumn('district');
            }

            if (Schema::hasColumn(self::TABLE_NAME, 'budget')) {
                $table->dropColumn('budget');
            }

            if (Schema::hasColumn(self::TABLE_NAME, 'locatie')) {
                $table->dropColumn('locatie');
            }

            if (Schema::hasColumn(self::TABLE_NAME, 'url')) {
                $table->dropColumn('url');
            }
        });
    }
}
