<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('telegram_chat_id')->nullable()->after('password'); // Menambahkan kolom telegram_chat_id
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('telegram_chat_id'); // Menghapus kolom jika rollback
    });
}
};
