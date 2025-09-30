<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 md:mb-0">All Posts</h1>
                <a href="{{ route('posts.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-200">
                    <i class="fas fa-plus mr-2"></i> New Post
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Posts List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach ($posts as $post)
                    <li class="p-6 hover:bg-gray-50 transition duration-150">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                            <!-- Post Content -->
                            <div class="flex-1 mb-4 md:mb-0">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $post->title }}</h2>
                                <p class="text-gray-600">{{ $post->content }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('posts.edit', $post) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg flex items-center transition duration-200">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg flex items-center transition duration-200"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Empty State -->
        @if(count($posts) === 0)
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-700 mb-2">No posts yet</h3>
                <p class="text-gray-500 mb-6">Get started by creating your first post.</p>
                <a href="{{ route('posts.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Create Post
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto px-4 py-6">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Posts App. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
