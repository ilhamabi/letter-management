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
        Schema::table('generated_letters', function (Blueprint $table) {
            $table->index('qr_token');
            $table->index('letter_number');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->index('status');
            $table->index('submitted_at');
            $table->index(['assigned_to_user_id', 'status']);
            $table->index(['student_id', 'status']);
        });

        Schema::table('submission_logs', function (Blueprint $table) {
            $table->index(['user_id', 'status']);
        });

        Schema::table('submission_group_members', function (Blueprint $table) {
            $table->index(['submission_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generated_letters', function (Blueprint $table) {
            $table->dropIndex(['qr_token']);
            $table->dropIndex(['letter_number']);
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['submitted_at']);
            $table->dropIndex(['assigned_to_user_id', 'status']);
            $table->dropIndex(['student_id', 'status']);
        });

        Schema::table('submission_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('submission_group_members', function (Blueprint $table) {
            $table->dropIndex(['submission_id', 'student_id']);
        });
    }
};
