<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('username')->unique()->after('id');
        //     $table->string('phone_number')->unique()->after('username');
        //     $table->string('withdrawal_password')->nullable()->after('password');
        //     $table->string('invitation_code')->unique()->after('withdrawal_password');
        //     $table->unsignedBigInteger('referrer_id')->nullable()->after('invitation_code');
        //     $table->string('language')->default('en')->after('referrer_id');
        //     $table->unsignedBigInteger('vip_level_id')->default(1)->after('language');
        //     $table->decimal('balance', 12, 2)->default(0)->after('vip_level_id');
        // });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
