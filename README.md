# Laracon Online 2020

![](https://raw.githubusercontent.com/reinink/wants/master/screenshot.png)

## Database Schema

- `users`
- `categories`
- `wants`
- `comments`
- `votes`

## Install the Laravel Debugbar

- `composer require barryvdh/laravel-debugbar --dev`
- Set `APP_DEBUG=true` in `.env`
- `php artisan vendor:publish` (9)
- Enable `models` in `config/debugbar.php`
- *Goals*
    1. Minimize database queries.
    2. Minimize hydrated models.
    3. Minimize memory usage.


## Requirement 1: Show status totals on dashboard

Update `views/wants.blade.php`:

```html
<div class="mb-12 grid grid-cols-3 gap-8">
    <div class="bg-orange-400 shadow rounded-lg flex items-center justify-between px-8 py-5">
        <div class="flex items-center">
            <svg class="text-white fill-current w-8 h-8" viewBox="0 0 20 20">
                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
            </svg>
            <div class="ml-3 text-white font-medium">Requested</div>
        </div>
        <div class="text-white ml-3 text-2xl font-medium">10</div>
    </div>
    <div class="bg-blue-500 shadow rounded-lg flex items-center justify-between px-8 py-5">
        <div class="flex items-center">
            <svg class="text-white fill-current w-7 h-7" viewBox="0 0 20 20">
                <path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z" />
            </svg>
            <div class="ml-3 text-white font-medium">Planned</div>
        </div>
        <div class="text-white ml-3 text-2xl font-medium">10</div>
    </div>
    <div class="bg-green-400 shadow rounded-lg flex items-center justify-between px-8 py-5">
        <div class="flex items-center">
            <svg class="text-white fill-current w-8 h-8" viewBox="0 0 20 20">
                <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
            </svg>
            <div class="ml-3 text-white font-medium">Completed</div>
        </div>
        <div class="text-white ml-3 text-2xl font-medium">10</div>
    </div>
</div>
```

Update `Controllers/WantsController.php`

```php
$wants = Want::all();
$statuses = (object) [];
$statuses->requested = $wants->where('status', 'Requested')->count();
$statuses->planned = $wants->where('status', 'Planned')->count();
$statuses->completed = $wants->where('status', 'Completed')->count();

return View::make('wants', [
    'statuses' => $statuses,
    'wants' => $wants,
]);
```

Update `views/wants.blade.php`:

```php
{{ $statuses->requested }}
{{ $statuses->planned }}
{{ $statuses->completed }}
```

Update `Controllers/WantsController.php`

```php
$statuses = (object) [];
$statuses->requested = Want::where('status', 'Requested')->count();
$statuses->planned = Want::where('status', 'Planned')->count();
$statuses->completed = Want::where('status', 'Completed')->count();
```

Update `Controllers/WantsController.php`

```php
$statuses = Want::getQuery()
    ->selectRaw("count(case when status = 'Requested' then 1 end) as requested")
    ->selectRaw("count(case when status = 'Planned' then 1 end) as planned")
    ->selectRaw("count(case when status = 'Completed' then 1 end) as completed")
    ->first();
```


## Requirement 2: Add comments links and author label

Update `app/Comment.php`

```php
public function url()
{
    return $this->want->url().'#comment-'.$this->id;
}
```

Update `views/want.blade.php`:

```html
<a class="hover:underline" href="{{ $comment->url() }}">
    {{ $comment->created_at->format('M j, Y \a\t g:i a') }}
</a>
```

Update `Controllers/WantsController.php`

```php
$want->load(['comments' => function ($query) {
    $query->with('user', 'want');
}]);
```

*Notes:*
- Still making two unnecessary database queries (`Want` and `Want::category()`).
- Let's amplify this problem.

Update `views/wants.blade.php`

```html
@if ($comment->isAuthor())
    <div class="flex items-center text-yellow-400">
        <svg class="fill-current w-3 h-3" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
        <div class="ml-1 text-xs font-medium">Author</div>
    </div>
@endif
```

Update `app/Comment.php`

```php
public function isAuthor()
{
    return $this->want
        ->comments
        ->sortBy('created_at')
        ->first()
        ->user
        ->is($this->user);
}
```

*What we have:*
- want
    - category `(to show at the top)`
    - comments `(to list the comments)`
        - user `(to show the comment user)`
        - **want**
            - category `(for the link)`
            - comments `(to determine first comment)`
                - user `(to get the author)`
*What we want:*
- want
    - category
    - comments
        - user

Update `Controllers/WantsController.php`

```php
$want->load('comments.user');
$want->comments->each->setRelation('want', $want);
```

*Notes:*
- What we're doing is optimizing in the perimeter of our app.
- Let's look at one last example.

Update `Controllers/WantsController.php`

```php
$want->load('comments.user:id,name,photo');
```


## Requirement 3: Add last comment to dashboard

Update `views/wants.blade.php`

```html
<th class="px-6 pt-5 pb-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" width="25%">
    <div class="inline-flex items-center hover:text-gray-900">
        <a class="" href="/?sort=last_comment">Last comment</a>
        @if (Request::input('sort') === 'last_comment')
            <svg class="block w-4 h-4 fill-current" viewBox="0 0 20 20"><polygon points="9.293 12.95 10 13.657 15.657 8 14.243 6.586 10 10.828 5.757 6.586 4.343 8" /></svg>
        @endif
    </div>
</th>
```

```html
<td class="px-6 py-4 border-b border-gray-200">
    <div class="flex items-center">
        <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-400">
            <img class="object-cover w-8 h-8" src="https://pbs.twimg.com/profile_images/885868801232961537/b1F6H4KC_400x400.jpg" />
        </div>
        <div class="ml-2">
            <div class="text-sm leading-5 text-gray-900">
                Jonathan Reinink
            </div>
            <div class="text-xs leading-5 text-gray-500">
                Feb 22, 2020 at 3:52 pm
            </div>
        </div>
    </div>
</td>
```

Update `app/Want.php`

```php
public function getLastCommentAttribute()
{
    return $this->comments->sortByDesc('created_at')->first();
}
```

Update `views/wants.blade.php`

```php
{{ $want->lastComment->user->photo }}
{{ $want->lastComment->user->name }}
{{ $want->lastComment->created_at->format('M j, Y \a\t g:i a') }}
```

Update `Controllers/WantsController.php`

```php
$wants = Want::query()
    ->with('category', 'comments.user')
```

*Notes:*
- We're now loading a TON of data.
- We're also loading too many users.
- And this problem becomes much worse if we show more than 15 results per page.
- Try `->paginate(100)`

Update `app/Want.php`

```php
public function lastComment()
{
    return $this->belongsTo(Comment::class);
}
```

*Notes:*
- But `wants.last_comment_id` does not exist.
- How can we make this relationship work?

```php
public function scopeWithLastCommentId($query)
{
    $query->addSelect(['last_comment_id' => Comment::select('id')
        ->whereColumn('comments.want_id', 'wants.id')
        ->latest()
        ->take(1),
    ]);
}
```

Update `Controllers/WantsController.php`

```php
$wants = Want::query()
    ->with('category', 'lastComment.user')
```

Update `Controllers/WantsController.php`

```php
$wants = Want::query()
    ->withLastCommentId()
```

Update `app/Want.php`

```php
protected static function boot()
{
    parent::boot();

    static::addGlobalScope('with_last_comment_id', function ($query) {
        $query->withLastCommentId();
    });
}
```

Update `Controllers/WantsController.php`

```php
$wants = Want::query()
    ->with('category', 'lastComment.user')
```


## Requirement 4: Add column sorting to dashboard

Update `Controllers/WantsController.php`

```php
->when(Request::input('sort'), function ($query, $sort) {
    switch ($sort) {
        case 'category': return $query->orderByCategory();
        case 'last_comment': return $query->orderByLastCommentDate();
        case 'status': return $query->orderByStatus();
        case 'activity': return $query->orderByActivity();
    }
})
```

Update `app/Want.php`

```php
public function scopeOrderByCategory($query)
{
}

public function scopeOrderByLastCommentDate($query)
{
}

public function scopeOrderByStatus($query)
{
}

public function scopeOrderByActivity($query)
{
}
```

Update `app/Want.php`

```php
public function scopeOrderByCategory($query)
{
    $query->orderBy(
        Category::select('name')
            ->whereColumn('categories.id', 'wants.category_id')
    );
}
```

Update `app/Want.php`

```php
public function scopeOrderByLastCommentDate($query)
{
    $query->orderByDesc(
        Comment::select('created_at')
            ->whereColumn('comments.want_id', 'wants.id')
            ->latest()
            ->take(1)
    );
}
```

Update `app/Want.php`

```php
public function scopeOrderByStatus($query)
{
    $query->orderByDesc('status');
}
```

Update `app/Want.php`

```php
public function scopeOrderByStatus($query)
{
    $query->orderByRaw("
        case
            when status = 'Requested' then 1
            when status = 'Planned' then 2
            when status = 'Completed' then 3
        end
    ");
}
```

Update `app/Want.php`

```php
public function scopeOrderByActivity($query)
{
    $votes = Vote::selectRaw('count(*)')
        ->whereColumn('votes.want_id', 'wants.id')
        ->toSql();

    $comments = Comment::selectRaw('count(*)')
        ->whereColumn('comments.want_id', 'wants.id')
        ->toSql();

    $query->orderByRaw("($votes) + (($comments) * 2) desc");
}
```

*Notes:*
- Test it using by adding it as a column:

```php
$query->selectRaw("($votes) + (($comments) * 2) as activity");
```
