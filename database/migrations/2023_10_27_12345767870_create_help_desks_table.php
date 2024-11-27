<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('help_desks', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->string('emp_id');
            $table->string('category');
            $table->string('mail');
            $table->string('distributor_name');
            $table->string('mobile');
            $table->string('subject');
            $table->text('description');
            $table->text('active_comment')->nullable();
            $table->text('inprogress_remarks')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('cc_to')->nullable();
            $table->tinyInteger('status_code')->default(8);
            $table->string('selected_equipment')->nullable();
            $table->enum('priority', ['High', 'Medium', 'Low']);
            $table->timestamps();

            $table->foreign('emp_id')
                ->references('emp_id')
                ->on('employee_details')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        // Creating the trigger to auto-generate request_id
        DB::statement("
        CREATE TRIGGER generate_request_id BEFORE INSERT ON help_desks FOR EACH ROW
        BEGIN
            DECLARE max_id INT;
    
            -- Fixed prefix for request_id
            SET @prefix = 'REQ-';
    
            -- If request_id is not provided, generate it
            IF NEW.request_id IS NULL OR NEW.request_id = '' THEN
                -- Find the maximum existing request_id
                SELECT MAX(CAST(SUBSTRING(request_id, LENGTH(@prefix) + 1) AS UNSIGNED)) 
                INTO max_id 
                FROM help_desks 
                WHERE request_id LIKE CONCAT(@prefix, '%');
    
                IF max_id IS NOT NULL THEN
                    -- Increment the counter and set the new request_id
                    SET NEW.request_id = CONCAT(@prefix, LPAD(max_id + 1, 4, '0'));
                ELSE
                    -- No existing requests, start from 0001
                    SET NEW.request_id = CONCAT(@prefix, '0001');
                END IF;
            END IF;
        END;
    ");
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the trigger if it exists
        DB::unprepared('DROP TRIGGER IF EXISTS generate_request_id');

        // Drop the table
        Schema::dropIfExists('help_desks');
    }
};