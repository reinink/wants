@extends('layout', ['title' => $want->title])

@section('content')

<header class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <h2 class="py-6 text-3xl font-bold leading-tight text-gray-900 flex items-center">
            <div>{{ $want->title }}</div>
            <div class="mt-1 ml-4 text-xs leading-normal px-1 font-normal text-gray-500 rounded border">
                {{ $want->category->name }}
            </div>
        </h2>
        <div class="flex items-center">
            @if ($want->status === 'Requested')
                <span class="bg-orange-400 rounded-full flex items-center justify-between px-6 py-2">
                    <div class="flex items-center">
                        <svg class="text-white fill-current w-4 h-4" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <div class="ml-2 text-white text-sm font-medium">Requested</div>
                    </div>
                </span>
            @elseif ($want->status === 'Planned')
                <span class="bg-blue-500 rounded-full flex items-center justify-between px-6 py-2">
                    <div class="flex items-center">
                        <svg class="text-white fill-current w-4 h-4" viewBox="0 0 20 20"><path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/></svg>
                        <div class="ml-2 text-white text-sm font-medium">Planned</div>
                    </div>
                </span>
            @elseif ($want->status === 'Completed')
                <span class="bg-green-400 rounded-full flex items-center justify-between px-6 py-2">
                    <div class="flex items-center">
                        <svg class="text-white fill-current w-4 h-4" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                        <div class="ml-2 text-white text-sm font-medium">Completed</div>
                    </div>
                </span>
            @endif
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto py-12 sm:px-6 lg:px-8">
    @foreach ($want->comments as $comment)
        <div class="px-10 py-8 bg-white shadow overflow-hidden sm:rounded-lg flex {{ $loop->first ? 'mb-8' : 'mb-4 max-w-4xl mx-auto' }}" id="comment-{{ $comment->id }}">
            <div class="whitespace-no-wrap pr-8 border-r">
                @if ($comment->user->photo)
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-red-400">
                        <img class="object-cover w-full h-full" src="{{ $comment->user->photo }}" />
                    </div>
                @endif
                <div class="mt-2 text-sm leading-5 text-gray-900">
                    {{ $comment->user->name }}
                </div>
                <div class="text-xs leading-5 text-gray-500">
                    {{ $comment->created_at->format('M j, Y \a\t g:i a') }}
                </div>
            </div>
            <div class="px-8 flex-1 flex items-center">
                {{ $comment->comment }}
            </div>
            @if ($loop->first)
                <div class="pl-8 border-l flex items-center">
                    <div class="flex items-baseline">
                        <svg class="fill-current text-green-500 w-5 h-5" viewBox="0 0 20 20"><path d="M11 0h1v3l3 7v8a2 2 0 01-2 2H5c-1.1 0-2.31-.84-2.7-1.88L0 12v-2a2 2 0 012-2h7V2a2 2 0 012-2zm6 10h3v10h-3V10z"/></svg>
                        <div class="ml-1 text-sm text-green-500 font-medium">{{ $want->votes()->count() }}</div>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</main>

@endsection
