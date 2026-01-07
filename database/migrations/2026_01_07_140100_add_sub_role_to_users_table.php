<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sub_role')->nullable()->after('role'); // dosen, mahasiswa for civitas
            $table->string('phone')->nullable()->after('email');
            $table->string('nim_nip')->nullable()->after('phone'); // NIM for mahasiswa, NIP for dosen/pegawai
            $table->string('avatar')->nullable()->after('nim_nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sub_role', 'phone', 'nim_nip', 'avatar']);
        });
    }
};
