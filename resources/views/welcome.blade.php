<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    {{-- Top navigation bar --}}
    <header class="bg-blue-700 text-white shadow">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="/" class="text-xl font-bold tracking-tight">My Blog</a>

            @auth
                <div class="flex items-center gap-3 sm:gap-4">
                    <span class="hidden text-sm text-blue-100 sm:inline">
                        Signed in as <span class="font-semibold text-white">{{ auth()->user()->name }}</span>
                    </span>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                            class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-700">
                            Log out
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-12">

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

        @auth
            <div class="grid gap-8 lg:grid-cols-3">

                {{-- Create post --}}
                <section class="lg:col-span-1">
                    <div class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm lg:sticky lg:top-8">
                        <h2 class="text-lg font-semibold text-blue-900">Write a new post</h2>
                        <p class="mt-1 text-sm text-slate-500">Share something with everyone.</p>

                        <form action="{{ route('createPost') }}" method="POST" class="mt-5 space-y-4">
                            @csrf
                            <div>
                                <label for="title" class="mb-1 block text-sm font-medium text-slate-700">Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Enter post title..." required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>

                            <div>
                                <label for="content" class="mb-1 block text-sm font-medium text-slate-700">Content</label>
                                <textarea id="content" name="content" rows="6"
                                    placeholder="Write your post here..." required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">{{ old('content') }}</textarea>
                            </div>

                            <button type="submit"
                                class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                                Publish post
                            </button>
                        </form>
                    </div>
                </section>

                {{-- Posts feed --}}
                <section class="lg:col-span-2">
                    <h2 class="mb-4 text-lg font-semibold text-blue-900">Latest posts</h2>

                    <div class="space-y-4">
                        @forelse ($posts as $post)
                            <article class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm">
                                <h3 class="text-xl font-semibold text-blue-800">{{ $post->title }}</h3>
                                @if ($post->created_at)
                                    <p class="mt-1 text-xs text-slate-400">{{ $post->created_at->diffForHumans() }}</p>
                                @endif
                                <p class="mt-3 whitespace-pre-line leading-relaxed text-slate-600">{{ $post->content }}</p>

                                <a href="/edit-post/{{ $post->id }}"
                                    class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>
                                <p><a href="/delete-post/{{ $post->id }}"
                                    class="mt-4 inline-block text-sm font-medium text-red-600 hover:text-red-800">
                                    Delete
                                </a></p>
                            </article>
                        @empty
                            <div class="rounded-2xl border border-dashed border-blue-200 bg-white p-10 text-center">
                                <p class="font-medium text-blue-900">No posts yet</p>
                                <p class="mt-1 text-sm text-slate-500">Use the form to publish the first one.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

        @else
            {{-- Guest: register and login --}}
            <div class="mx-auto max-w-4xl">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold tracking-tight text-blue-900 sm:text-4xl">Welcome to My Blog</h1>
                    <p class="mt-2 text-slate-500">Create an account or log in to read and write posts.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">

                    {{-- Register --}}
                    <section class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="text-lg font-semibold text-blue-900">Create an account</h2>

                        <form action="{{ route('register') }}" method="POST" class="mt-5 space-y-4">
                            @csrf
                            <div>
                                <label for="reg-name" class="mb-1 block text-sm font-medium text-slate-700">Name</label>
                                <input type="text" id="reg-name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your name" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                            <div>
                                <label for="reg-email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                                <input type="email" id="reg-email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter your email" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                            <div>
                                <label for="reg-password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                                <input type="password" id="reg-password" name="password"
                                    placeholder="Enter your password" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                            <button type="submit"
                                class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                                Register
                            </button>
                        </form>
                    </section>

                    {{-- Login --}}
                    <section class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="text-lg font-semibold text-blue-900">Log in</h2>

                        <form action="{{ route('login') }}" method="POST" class="mt-5 space-y-4">
                            @csrf
                            <div>
                                <label for="login-name" class="mb-1 block text-sm font-medium text-slate-700">Name</label>
                                <input type="text" id="login-name" name="name"
                                    placeholder="Enter your name" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                            <div>
                                <label for="login-password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                                <input type="password" id="login-password" name="password"
                                    placeholder="Enter your password" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                            <button type="submit"
                                class="w-full rounded-lg border border-blue-600 bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                                Log in
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        @endauth

    </main>
</body>
</html>