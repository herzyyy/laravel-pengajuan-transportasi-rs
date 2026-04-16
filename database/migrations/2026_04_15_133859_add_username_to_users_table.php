<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('last_name');
        });

        // Backfill username untuk user yang sudah ada
        foreach (User::all() as $user) {
            $parts = preg_split('/\s+/', trim($user->first_name . ' ' . $user->last_name));
            $w1 = strtolower(preg_replace('/[^a-z0-9.]/i', '', $parts[0] ?? ''));
            $w2raw = $parts[1] ?? null;
            $w2 = ($w2raw && strpos($w2raw, '.') === false)
                ? strtolower(preg_replace('/[^a-z0-9]/i', '', $w2raw))
                : null;
            $base = rtrim($w1, '.');
            $username = ($w2 && $w2 !== '') ? "{$base}.{$w2}" : $base;

            // Handle duplikat
            $final = $username;
            $i = 1;
            while (User::where('username', $final)->where('id', '!=', $user->id)->exists()) {
                $final = $username . $i++;
            }
            $user->update(['username' => $final]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
