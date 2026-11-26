<?php

use App\Observers\RatingObserver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $lastId = 0;

        do {
            $duplicates = DB::table('ratings')->select('post_id', 'user_id')
                ->selectRaw('MAX(id) AS latest_id')
                ->groupBy('post_id', 'user_id')
                ->havingRaw('COUNT(*) > 1 AND MAX(id) > ?', [$lastId])
                ->orderBy('latest_id')
                ->limit(500)
                ->get();

            foreach ($duplicates as $vote) {
                DB::table('ratings')->where('post_id', $vote->post_id)->where('user_id', $vote->user_id)
                    ->where('id', '<', $vote->latest_id)->delete();
                $lastId = $vote->latest_id;
            }
        } while ($duplicates->isNotEmpty());

        Schema::table('ratings', function (Blueprint $table) {
            $table->unique(['post_id', 'user_id'], 'ratings_post_user_unique');
            $table->index(['post_id', 'rating'], 'ratings_post_value_index');
        });
        if ($lastId > 0) {
            // Direct database writes bypass the rating observer.
            DB::afterCommit(fn () => app(RatingObserver::class)->saved());
        }
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropUnique('ratings_post_user_unique');
            $table->dropIndex('ratings_post_value_index');
        });
    }
};
