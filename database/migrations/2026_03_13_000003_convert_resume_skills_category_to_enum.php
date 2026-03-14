<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const ENUM_VALUES = "'programming_languages','scripting_languages','markup_languages','query_languages','frontend_technologies','backend_technologies','full_stack_development','frameworks','libraries','ui_ux_design','responsive_design','mobile_development','desktop_development','game_development','embedded_systems','databases','database_design','database_administration','orm_data_access','api_development','web_services','graphql','microservices','event_driven_architecture','devops','cloud_platforms','serverless','containerization','ci_cd','infrastructure_as_code','configuration_management','version_control','testing_qa','test_automation','security','authentication_authorization','networking','performance_optimization','architecture_design_patterns','system_design','distributed_systems','data_engineering','big_data','machine_learning_ai','monitoring_logging','development_tools','operating_systems','project_management','agile_methodologies','soft_skills'";

    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            // Step 1: make column nullable so we can NULL out non-matching free-text values
            DB::statement('ALTER TABLE resume_skills MODIFY category VARCHAR(255) NULL');
        }

        // Step 2: NULL any existing value that is not a valid enum member
        DB::statement('UPDATE resume_skills SET category = NULL WHERE category NOT IN (' . self::ENUM_VALUES . ')');

        if (DB::getDriverName() !== 'sqlite') {
            // Step 3: convert to nullable enum (preserves rows that already had valid values)
            DB::statement('ALTER TABLE resume_skills MODIFY category ENUM(' . self::ENUM_VALUES . ') NULL');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE resume_skills MODIFY category VARCHAR(255) NULL');
        }
    }
};
