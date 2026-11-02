<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    {{-- Top navigation bar --}}
    <header class="bg-blue-700 text-white shadow">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="/" class="text-xl font-bold tracking-tight">My Blog</a>
        </div>
    </header>

    <main class="mx-auto max-w-2xl px-4 py-8 sm:px-6 sm:py-12">

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-xl font-semibold text-blue-900">Edit post</h1>
            <p class="mt-1 text-sm text-slate-500">Update your title or content, then save.</p>

            <form action="/edit-post/{{ $post->id }}" method="POST" class="mt-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="mb-1 block text-sm font-medium text-slate-700">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label for="content" class="mb-1 block text-sm font-medium text-slate-700">Content</label>
                    <textarea id="content" name="content" rows="8" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                        Update post
                    </button>
                    <a href="/"
                        class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </main>
</body>
</html>