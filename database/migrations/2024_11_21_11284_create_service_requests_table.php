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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->smallInteger('id')->autoIncrement(); // Incident Request ID
            $table->string('service_id', 10)->nullable()->unique(); // Auto-generated Service ID
            $table->string('emp_id',10);
            $table->string('category');
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->string('assigned_dept')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->tinyInteger('status_code')->default(11);
            $table->timestamps(); // created_at and updated_at
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
        // Create the trigger for auto-generating service_id
        $triggerSQL = <<<SQL
          CREATE TRIGGER generate_service_id BEFORE INSERT ON service_requests FOR EACH ROW
          BEGIN
              IF NEW.service_id IS NULL THEN
                  -- Generate SER-0001 style ID
                  SET @max_id := IFNULL(
                      (SELECT MAX(CAST(SUBSTRING(service_id, 5) AS UNSIGNED)) FROM service_requests),
                      0
                  ) + 1;

                  SET NEW.service_id = CONCAT('SER-', LPAD(@max_id, 4, '0'));
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
        DB::unprepared('DROP TRIGGER IF EXISTS generate_service_id');

        // Drop the table
        Schema::dropIfExists('service_requests');
    }
};
