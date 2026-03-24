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
        Schema::table('api_keys', function (Blueprint $table): void {
            $table->string('key_hash')->nullable()->after('user_id');
            $table->string('key_last4', 4)->nullable()->after('key_hash');
            $table->unsignedBigInteger('usage_count')->default(0)->after('usage_limit');
        });

        DB::table('api_keys')
            ->select(['id', 'key'])
            ->orderBy('id')
            ->chunkById(500, function ($keys): void {
                foreach ($keys as $apiKey) {
                    $rawKey = (string) $apiKey->key;
                    DB::table('api_keys')
                        ->where('id', $apiKey->id)
                        ->update([
                            'key_hash' => hash('sha256', $rawKey),
                            'key_last4' => substr($rawKey, -4),
                        ]);
                }
            });

        Schema::table('api_keys', function (Blueprint $table): void {
            $table->dropUnique(['key']);
            $table->dropColumn('key');
            $table->unique('key_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('api_keys', function (Blueprint $table): void {
            $table->string('key')->nullable()->after('user_id');
        });

        DB::table('api_keys')->update(['key' => '']);

        Schema::table('api_keys', function (Blueprint $table): void {
            $table->unique('key');
            $table->dropUnique(['key_hash']);
            $table->dropColumn(['key_hash', 'key_last4', 'usage_count']);
        });
    }
};
