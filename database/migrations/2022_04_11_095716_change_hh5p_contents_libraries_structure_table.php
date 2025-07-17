<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeHh5pContentsLibrariesStructureTable extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlsrv') {
            $this->dropPrimaryConstraintIfExists('hh5p_contents_libraries');
            $this->dropPrimaryConstraintIfExists('hh5p_libraries_languages');
            $this->dropPrimaryConstraintIfExists('hh5p_libraries_dependencies');
        } else {
            Schema::table('hh5p_contents_libraries', function (Blueprint $table) {
                $table->dropPrimary();
            });
            Schema::table('hh5p_libraries_languages', function (Blueprint $table) {
                $table->dropPrimary();
            });
            Schema::table('hh5p_libraries_dependencies', function (Blueprint $table) {
                $table->dropPrimary();
            });
        }

        Schema::table('hh5p_contents_libraries', function (Blueprint $table) {
            $table->unique(['content_id', 'library_id', 'dependency_type'], 'hh5p_contents_libraries_unique_key');
            $table->id();
        });

        Schema::table('hh5p_libraries_languages', function (Blueprint $table) {
            $table->unique(['library_id', 'language_code'], 'hh5p_libraries_languages_unique_key');
            $table->id();
        });

        Schema::table('hh5p_libraries_dependencies', function (Blueprint $table) {
            $table->unique(['library_id', 'required_library_id'], 'hh5p_libraries_dependencies_unique_key');
            $table->id();
        });
    }

    public function down(): void
    {
        Schema::table('hh5p_contents_libraries', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropUnique('hh5p_contents_libraries_unique_key');
        });

        Schema::table('hh5p_libraries_languages', function (Blueprint $table) {
            $table->dropUnique('hh5p_libraries_languages_unique_key');
            $table->dropColumn('id');
        });

        Schema::table('hh5p_libraries_dependencies', function (Blueprint $table) {
            $table->dropUnique('hh5p_libraries_dependencies_unique_key');
            $table->dropColumn('id');
        });

        Schema::table('hh5p_contents_libraries', function (Blueprint $table) {
            $table->primary(['content_id', 'library_id', 'dependency_type']);
        });

        Schema::table('hh5p_libraries_languages', function (Blueprint $table) {
            $table->primary(['library_id', 'language_code']);
        });

        Schema::table('hh5p_libraries_dependencies', function (Blueprint $table) {
            $table->primary(['library_id', 'required_library_id']);
        });
    }

    /**
     * Tự động dò và xóa primary key constraint trong SQL Server.
     */
    protected function dropPrimaryConstraintIfExists(string $tableName): void
    {
        $constraint = DB::table('sys.key_constraints')
            ->join('sys.tables', 'key_constraints.parent_object_id', '=', 'tables.object_id')
            ->where('tables.name', $tableName)
            ->where('key_constraints.type', 'PK')
            ->select('key_constraints.name')
            ->first();

        if ($constraint) {
            DB::statement("ALTER TABLE {$tableName} DROP CONSTRAINT {$constraint->name}");
        }
    }
}