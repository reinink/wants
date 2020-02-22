<?php

use App\User;
use App\Vote;
use App\Want;
use App\Comment;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        factory(User::class, 250)->create();

        Category::create(['name' => 'Billing', 'slug' => 'billing']);
        Category::create(['name' => 'Bug', 'slug' => 'bug']);
        Category::create(['name' => 'Desktop', 'slug' => 'desktop']);
        Category::create(['name' => 'Integrations', 'slug' => 'integrations']);
        Category::create(['name' => 'Mobile', 'slug' => 'mobile']);
        Category::create(['name' => 'Performance', 'slug' => 'performance']);
        Category::create(['name' => 'Security', 'slug' => 'security']);
        Category::create(['name' => 'UI/UX', 'slug' => 'ui-ux']);

        $users = User::all();
        $categories = Category::all();

        factory(Want::class, 250)->make()->each(function ($want) use ($users, $categories) {
            $want->category_id = Str::startsWith($want->status, 'Fix')
                ? $categories->where('name', 'Bug')->id
                : $categories->random()->id;

            $want->save();

            $want->comments()->createMany(
                factory(Comment::class, rand(1, 50))->make()->each(function ($comment) use ($users) {
                    $comment->user_id = $users->random()->id;
                })->toArray()
            );

            $want->votes()->createMany(
                factory(Vote::class, rand(0, 250))->make()->each(function ($vote) use ($users) {
                    $vote->user_id = $users->random()->id;
                })->toArray()
            );
        });
    }
}
