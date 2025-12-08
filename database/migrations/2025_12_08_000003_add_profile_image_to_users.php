<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Use raw SQL to avoid older MySQL information_schema issues
        try {
            DB::statement("ALTER TABLE `users` ADD COLUMN `profile_image` VARCHAR(255) NULL AFTER `remember_token`");
        } catch (\Exception $e) {
            // ignore if column already exists or database doesn't support introspection
        }
    }

    public function down()
    {
        try {
            DB::statement("ALTER TABLE `users` DROP COLUMN `profile_image`");
        } catch (\Exception $e) {
            // ignore
        }
    }
};
