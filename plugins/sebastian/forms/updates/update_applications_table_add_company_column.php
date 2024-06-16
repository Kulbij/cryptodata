<?php namespace Sebastian\Marketplace\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateApplicationsTableAddCompanyColumn extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('sebastian_forms_applications', 'company_name')) {
            return;
        }
        
        Schema::table('sebastian_forms_applications', function(Blueprint $table) {
            $table->string('company_name')->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasTable('sebastian_forms_applications')) {
            Schema::table('sebastian_forms_applications', function (Blueprint $table) {
                if (Schema::hasColumn('sebastian_forms_applications', 'company_name')) {
                    $table->dropColumn('company_name');
                }
            });
        }
    }
}
