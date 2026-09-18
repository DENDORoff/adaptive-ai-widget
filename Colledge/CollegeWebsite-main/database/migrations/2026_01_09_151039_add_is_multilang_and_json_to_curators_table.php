<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::table('curators', function (Blueprint $table) {
            $table->json('curator_name_json')->nullable()->after('curator_name');
            $table->json('curator_position_json')->nullable()->after('curator_position');
            $table->json('group_name_json')->nullable()->after('group_name');
            $table->json('specialty_json')->nullable()->after('specialty');
            $table->json('room_number_json')->nullable()->after('room_number');
            $table->json('consultation_schedule_json')->nullable()->after('consultation_schedule');
            $table->json('additional_info_json')->nullable()->after('additional_info');
            $table->boolean('is_multilang')->default(false)->after('order');
        });

        
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement("
                UPDATE curators 
                SET 
                    curator_name_json = json_build_object('ru', curator_name, 'kk', '', 'en', ''),
                    curator_position_json = CASE 
                        WHEN curator_position IS NOT NULL AND curator_position != '' 
                        THEN json_build_object('ru', curator_position, 'kk', '', 'en', '')
                        ELSE '{\"ru\": \"\", \"kk\": \"\", \"en\": \"\"}'::json
                    END,
                    group_name_json = json_build_object('ru', group_name, 'kk', '', 'en', ''),
                    specialty_json = CASE 
                        WHEN specialty IS NOT NULL AND specialty != '' 
                        THEN json_build_object('ru', specialty, 'kk', '', 'en', '')
                        ELSE '{\"ru\": \"\", \"kk\": \"\", \"en\": \"\"}'::json
                    END,
                    room_number_json = CASE 
                        WHEN room_number IS NOT NULL AND room_number != '' 
                        THEN json_build_object('ru', room_number, 'kk', '', 'en', '')
                        ELSE '{\"ru\": \"\", \"kk\": \"\", \"en\": \"\"}'::json
                    END,
                    consultation_schedule_json = CASE 
                        WHEN consultation_schedule IS NOT NULL AND consultation_schedule != '' 
                        THEN json_build_object('ru', consultation_schedule, 'kk', '', 'en', '')
                        ELSE '{\"ru\": \"\", \"kk\": \"\", \"en\": \"\"}'::json
                    END,
                    additional_info_json = CASE 
                        WHEN additional_info IS NOT NULL AND additional_info != '' 
                        THEN json_build_object('ru', additional_info, 'kk', '', 'en', '')
                        ELSE '{\"ru\": \"\", \"kk\": \"\", \"en\": \"\"}'::json
                    END
            ");
        } else {
            $dataFields = [
                'curator_name', 'curator_position', 'group_name', 'specialty',
                'room_number', 'consultation_schedule', 'additional_info',
            ];
            foreach (DB::table('curators')->get() as $row) {
                $payload = [];
                foreach ($dataFields as $field) {
                    $value = $row->{$field} ?? '';
                    $payload[$field.'_json'] = json_encode([
                        'ru' => (string) $value,
                        'kk' => '',
                        'en' => '',
                    ], JSON_UNESCAPED_UNICODE);
                }
                DB::table('curators')->where('id', $row->id)->update($payload);
            }
        }

        if (DB::connection()->getDriverName() !== 'pgsql') {
            Schema::table('curators', function (Blueprint $table) {
                $table->dropIndex('curators_curator_name_index');
            });
        }

        
        Schema::table('curators', function (Blueprint $table) {
            $table->dropColumn('curator_name');
            $table->dropColumn('curator_position');
            $table->dropColumn('group_name');
            $table->dropColumn('specialty');
            $table->dropColumn('room_number');
            $table->dropColumn('consultation_schedule');
            $table->dropColumn('additional_info');
        });

        
        Schema::table('curators', function (Blueprint $table) {
            $table->renameColumn('curator_name_json', 'curator_name');
            $table->renameColumn('curator_position_json', 'curator_position');
            $table->renameColumn('group_name_json', 'group_name');
            $table->renameColumn('specialty_json', 'specialty');
            $table->renameColumn('room_number_json', 'room_number');
            $table->renameColumn('consultation_schedule_json', 'consultation_schedule');
            $table->renameColumn('additional_info_json', 'additional_info');
        });
    }

    public function down(): void
    {
        
        Schema::table('curators', function (Blueprint $table) {
            $table->string('curator_name_old')->nullable();
            $table->string('curator_position_old')->nullable();
            $table->string('group_name_old')->nullable();
            $table->string('specialty_old')->nullable();
            $table->string('room_number_old')->nullable();
            $table->text('consultation_schedule_old')->nullable();
            $table->text('additional_info_old')->nullable();
        });

        
        DB::statement("
            UPDATE curators 
            SET 
                curator_name_old = COALESCE(curator_name->>'ru', ''),
                curator_position_old = COALESCE(curator_position->>'ru', ''),
                group_name_old = COALESCE(group_name->>'ru', ''),
                specialty_old = COALESCE(specialty->>'ru', ''),
                room_number_old = COALESCE(room_number->>'ru', ''),
                consultation_schedule_old = COALESCE(consultation_schedule->>'ru', ''),
                additional_info_old = COALESCE(additional_info->>'ru', '')
        ");

        
        Schema::table('curators', function (Blueprint $table) {
            $table->dropColumn('curator_name');
            $table->dropColumn('curator_position');
            $table->dropColumn('group_name');
            $table->dropColumn('specialty');
            $table->dropColumn('room_number');
            $table->dropColumn('consultation_schedule');
            $table->dropColumn('additional_info');
        });

        
        Schema::table('curators', function (Blueprint $table) {
            $table->renameColumn('curator_name_old', 'curator_name');
            $table->renameColumn('curator_position_old', 'curator_position');
            $table->renameColumn('group_name_old', 'group_name');
            $table->renameColumn('specialty_old', 'specialty');
            $table->renameColumn('room_number_old', 'room_number');
            $table->renameColumn('consultation_schedule_old', 'consultation_schedule');
            $table->renameColumn('additional_info_old', 'additional_info');
            
            $table->dropColumn('is_multilang');
        });
    }
};