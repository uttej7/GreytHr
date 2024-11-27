<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incident_requests', function (Blueprint $table) {
            $table->smallIncrements('id'); // Auto increment id as primary key
            $table->string('snow_id')->nullable()->unique(); // Auto-generated Incident/Service Request ID
            $table->string('emp_id', 10);
            $table->string('category'); // 'Incident Request' or 'Service Request'
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->string('assigned_dept')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->tinyInteger('status_code')->default(11); // Default to a "Pending" status
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('emp_id')
                ->references('emp_id')
                ->on('employee_details')
                ->onDelete('restrict');
            $table->foreign('status_code')
                ->references('status_code')
                ->on('status_types')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        // Create the trigger for auto-generating snow_id
        $triggerSQL = <<<SQL
        CREATE TRIGGER generate_snow_id BEFORE INSERT ON incident_requests FOR EACH ROW
        BEGIN
            -- Ensure snow_id is generated only if not provided
            IF NEW.snow_id IS NULL THEN
                IF NEW.category = 'Incident Request' THEN
                    -- Get the max increment value for 'Incident Request'
                    SET @max_id := IFNULL(
                        (SELECT MAX(CAST(SUBSTRING(snow_id, 5) AS UNSIGNED)) 
                         FROM incident_requests WHERE snow_id LIKE 'INC-%'),
                        0
                    ) + 1;

                    SET NEW.snow_id = CONCAT('INC-', LPAD(@max_id, 4, '0'));
                ELSEIF NEW.category = 'Service Request' THEN
                    -- Get the max increment value for 'Service Request'
                    SET @max_id := IFNULL(
                        (SELECT MAX(CAST(SUBSTRING(snow_id, 5) AS UNSIGNED)) 
                         FROM incident_requests WHERE snow_id LIKE 'SER-%'),
                        0
                    ) + 1;

                    SET NEW.snow_id = CONCAT('SER-', LPAD(@max_id, 4, '0'));
                END IF;
            END IF;
        END;
        SQL;

        DB::unprepared($triggerSQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the trigger
        DB::unprepared('DROP TRIGGER IF EXISTS generate_snow_id');
        // Drop the table
        Schema::dropIfExists('incident_requests');
    }
};
