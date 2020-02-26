@extends('layout', ['title' => 'Dashboard'])

@section('content')

<header class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <h2 class="py-6 text-3xl font-bold leading-tight text-gray-900">
            Dashboard
        </h2>
        <span class="shadow-sm rounded-md">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:shadow-outline focus:border-blue-300 transition duration-150 ease-in-out">
                New want
            </button>
        </span>
    </div>
</header>

<main class="max-w-6xl mx-auto py-12 sm:px-6 lg:px-8">
    <div class="mb-12 grid grid-cols-3 gap-8">
        <div class="bg-orange-400 shadow rounded-lg flex items-center justify-between px-8 py-5">
            <div class="flex items-center">
                <svg class="text-white fill-current w-8 h-8" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                </svg>
                <div class="ml-3 text-white font-medium">Requested</div>
            </div>
            <div class="text-white ml-3 text-2xl font-medium">{{ $statuses->requested }}</div>
        </div>
        <div class="bg-blue-500 shadow rounded-lg flex items-center justify-between px-8 py-5">
            <div class="flex items-center">
                <svg class="text-white fill-current w-7 h-7" viewBox="0 0 20 20">
                    <path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z" />
                </svg>
                <div class="ml-3 text-white font-medium">Planned</div>
            </div>
            <div class="text-white ml-3 text-2xl font-medium">{{ $statuses->planned }}</div>
        </div>
        <div class="bg-green-400 shadow rounded-lg flex items-center justify-between px-8 py-5">
            <div class="flex items-center">
                <svg class="text-white fill-current w-8 h-8" viewBox="0 0 20 20">
                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                </svg>
                <div class="ml-3 text-white font-medium">Completed</div>
            </div>
            <div class="text-white ml-3 text-2xl font-medium">{{ $statuses->completed }}</div>
        </div>
    </div>
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 pt-5 pb-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" width="35%">
                            <div class="inline-flex items-center hover:text-gray-900">
                                <a class="" href="/?sort=category">Want / Category</a>
                                @if (Request::input('sort') === 'category')
                                    <svg class="block w-4 h-4 fill-current" viewBox="0 0 20 20"><polygon points="9.293 12.95 10 13.657 15.657 8 14.243 6.586 10 10.828 5.757 6.586 4.343 8" /></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 pt-5 pb-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" width="25%">
                            <div class="inline-flex items-center hover:text-gray-900">
                                <a class="" href="/?sort=last_comment">Last comment</a>
                                @if (Request::input('sort') === 'last_comment')
                                    <svg class="block w-4 h-4 fill-current" viewBox="0 0 20 20"><polygon points="9.293 12.95 10 13.657 15.657 8 14.243 6.586 10 10.828 5.757 6.586 4.343 8" /></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 pt-5 pb-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" width="15%">
                            <div class="inline-flex items-center hover:text-gray-900">
                                <a class="" href="/?sort=status">Status</a>
                                @if (Request::input('sort') === 'status')
                                    <svg class="block w-4 h-4 fill-current" viewBox="0 0 20 20"><polygon points="9.293 12.95 10 13.657 15.657 8 14.243 6.586 10 10.828 5.757 6.586 4.343 8" /></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 pt-5 pb-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" width="15%">
                            <div class="inline-flex items-center hover:text-gray-900">
                                <a class="" href="/?sort=activity">Activity</a>
                                @if (Request::input('sort') === 'activity')
                                    <svg class="block w-4 h-4 fill-current" viewBox="0 0 20 20"><polygon points="9.293 12.95 10 13.657 15.657 8 14.243 6.586 10 10.828 5.757 6.586 4.343 8" /></svg>
                                @endif
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($wants as $want)
                        <tr class="hover:bg-gray-50 transition duration-100">
                            <td class="px-6 py-4 border-b border-gray-200">
                                <div>
                                    <a href="{{ $want->url() }}" class="leading-5 text-gray-900 hover:text-green-500 font-medium">
                                        {{ $want->title }}
                                    </a>
                                </div>
                                <div class="inline-block text-xs leading-normal px-1 text-gray-500 rounded border">
                                    {{ $want->category->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-400">
                                        <img class="object-cover w-8 h-8" src="{{ $want->lastComment->user->photo }}" />
                                    </div>
                                    <div class="ml-2">
                                        <div class="text-sm leading-5 text-gray-900">
                                            {{ $want->lastComment->user->name }}
                                        </div>
                                        <div class="text-xs leading-5 text-gray-500">
                                            {{ $want->lastComment->created_at->format('M j, Y \a\t g:i a') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                @if ($want->status === 'Requested')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-700">
                                        Requested
                                    </span>
                                @elseif ($want->status === 'Planned')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-700">
                                        Planned
                                    </span>
                                @elseif ($want->status === 'Completed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex items-baseline">
                                        <svg class="fill-current text-green-500 w-3 h-3" viewBox="0 0 20 20"><path d="M11 0h1v3l3 7v8a2 2 0 01-2 2H5c-1.1 0-2.31-.84-2.7-1.88L0 12v-2a2 2 0 012-2h7V2a2 2 0 012-2zm6 10h3v10h-3V10z"/></svg>
                                        <div class="ml-1 text-sm text-green-500 font-medium">{{ $want->votes_count }}</div>
                                    </div>
                                    <div class="ml-3 flex items-center">
                                        <svg class="fill-current text-green-500 w-3 h-3 mt-2px" viewBox="0 0 40 40" width="40" height="40"><title>Exported from Streamline App (https://app.streamlineicons.com)</title><g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)"><path d="M21.5,2h-19C1.672,2,1,2.672,1,3.5v13C1,17.328,1.672,18,2.5,18h4.252c0.138,0,0.25,0.112,0.25,0.25v3.25 c0,0.276,0.224,0.5,0.5,0.5c0.132,0,0.259-0.052,0.353-0.146l3.781-3.781C11.683,18.026,11.747,18,11.813,18H21.5 c0.828,0,1.5-0.672,1.5-1.5v-13C23,2.672,22.328,2,21.5,2z" stroke="none" stroke-width="0" stroke-linecap="round" stroke-linejoin="round"></path></g></svg>
                                        <div class="ml-1 text-sm text-green-500 font-medium">{{ $want->comments_count }}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 pt-5 pb-3 bg-gray-50">
                {{ $wants->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</main>

@endsection
