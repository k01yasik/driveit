<?php

use Illuminate\Database\Seeder;
use App\Comment;
use App\User;
use App\Post;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $post = Post::find(119);

        $comment = new Comment;
        $comment->user()->associate($user);
        $comment->post()->associate($post);
        $comment->message = 'Test message - first level';
        $comment->is_verified = true;
        $comment->level = 0;
        $comment->save();

        $comment1 = new Comment;
        $comment1->user()->associate($user);
        $comment1->post()->associate($post);
        $comment1->message = 'Test message 2 - second level';
        $comment1->is_verified = true;
        $comment1->level = 1;
        $comment1->parent_id = $comment->id;
        $comment1->save();

        $comment2 = new Comment;
        $comment2->user()->associate($user);
        $comment2->post()->associate($post);
        $comment2->message = 'Test message 3 - second level';
        $comment2->is_verified = true;
        $comment2->level = 1;
        $comment2->parent_id = $comment->id;
        $comment2->save();

        $comment3 = new Comment;
        $comment3->user()->associate($user);
        $comment3->post()->associate($post);
        $comment3->message = 'Test message 4 - third level';
        $comment3->is_verified = true;
        $comment3->level = 2;
        $comment3->parent_id = $comment2->id;
        $comment3->save();

        $comment4 = new Comment;
        $comment4->user()->associate($user);
        $comment4->post()->associate($post);
        $comment4->message = 'Test message 5 - fourth level';
        $comment4->is_verified = true;
        $comment4->level = 3;
        $comment4->parent_id = $comment3->id;
        $comment4->save();

        $comment4 = new Comment;
        $comment4->user()->associate($user);
        $comment4->post()->associate($post);
        $comment4->message = 'Test working - third level';
        $comment4->is_verified = true;
        $comment4->level = 2;
        $comment4->parent_id = $comment1->id;
        $comment4->save();
    }
}
