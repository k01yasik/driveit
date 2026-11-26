<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $lastId = 0;

        do {
            $duplicates = DB::table('category_post')->select('category_id', 'post_id')
                ->selectRaw('MIN(id) AS first_id')
                ->groupBy('category_id', 'post_id')
                ->havingRaw('COUNT(*) > 1 AND MIN(id) > ?', [$lastId])
                ->orderBy('first_id')
                ->limit(500)
                ->get();

            foreach ($duplicates as $link) {
                DB::table('category_post')->where('category_id', $link->category_id)
                    ->where('post_id', $link->post_id)->where('id', '>', $link->first_id)->delete();

                $lastId = $link->first_id;
            }
        } while ($duplicates->isNotEmpty());

        Schema::table('category_post', function (Blueprint $table) {
            $table->unique(['category_id', 'post_id'], 'category_post_pair_unique');
            $table->index('post_id', 'category_post_post_index');
        });
    }

    public function down(): void
    {
        Schema::table('category_post', function (Blueprint $table) {
            $table->dropUnique('category_post_pair_unique');
            $table->dropIndex('category_post_post_index');
        });
    }
};
