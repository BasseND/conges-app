<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY role VARCHAR(255) NOT NULL DEFAULT 'employee'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY role VARCHAR(255) NOT NULL");
    }
};
