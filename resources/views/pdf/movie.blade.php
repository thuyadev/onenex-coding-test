<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Movie</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" border="border">
        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
        <tr>
            <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">
                Movie Name
            </th>
            <th scope="col" class="py-3 px-6">
                Author
            </th>
            <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">
                Imdb Rating
            </th>
            <th scope="col" class="py-3 px-6">
                Genres
            </th>
            <th scope="col" class="py-3 px-6">
                Tags
            </th>
            <th scope="col" class="py-3 px-6">
                Summary
            </th>
        </tr>
        </thead>
        <tbody>
        <tr class="border-b border-gray-200 dark:border-gray-700">
            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                {{ $movie->title }}
            </th>
            <td class="py-4 px-6">
                {{ $movie->author }}
            </td>
            <td class="py-4 px-6 bg-gray-50 dark:bg-gray-800">
                {{ $movie->imdb_rating }}
            </td>
            <td class="py-4 px-6">
                @forelse($movie->genres as $genre)
                    {{ $genre->name }}
                    @if(!$loop->last)
                        ,
                    @endif
                @empty
                    Empty
                @endforelse
            </td>
            <td class="py-4 px-6">
                @forelse($movie->tags as $tag)
                    {{ $tag->name }}
                    @if(!$loop->last)
                        ,
                    @endif
                @empty
                    Empty
                @endforelse
            </td>
            <td class="py-4 px-6 bg-gray-50 dark:bg-gray-800">
                {{ $movie->summary }}
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
