@extends('layout', ['title' => 'Categories'])

@section('content')

<header class="bg-white shadow">
    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
        <h2 class="text-3xl font-bold leading-tight text-gray-900">
            Categories
        </h2>
        <span class="shadow-sm rounded-md">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:shadow-outline focus:border-blue-300 transition duration-150 ease-in-out">
                New category
            </button>
        </span>
    </div>
</header>
<main class="max-w-6xl mx-auto py-12 sm:px-6 lg:px-8">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 pt-5 pb-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 pt-5 pb-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Other
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="hover:bg-gray-50 cursor-pointer transition duration-100">
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            Security
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            Other
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

@endsection
