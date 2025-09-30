<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Post</h1>
                <a href="{{ route('posts.index') }}"
                   class="text-gray-600 hover:text-gray-900 flex items-center transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Posts
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-md p-6 md:p-8">
                <form action="{{ route('posts.update', $post) }}" method="POST">
                    @csrf @method('PUT')

                    <!-- Title Field -->
                    <div class="mb-6">
                        <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ $post->title }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                               placeholder="Enter post title"
                               required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content Field -->
                    <div class="mb-8">
                        <label for="content" class="block text-gray-700 font-medium mb-2">Content</label>
                        <textarea id="content"
                                  name="content"
                                  rows="6"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                                  placeholder="Write your post content here..."
                                  required>{{ $post->content }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg flex items-center justify-center transition duration-200">
                            <i class="fas fa-save mr-2"></i> Update Post
                        </button>
                        <a href="{{ route('posts.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg flex items-center justify-center transition duration-200">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Editing Tips</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Make sure your title is clear and descriptive. Keep your content focused and engaging for readers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto px-4 py-6">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Posts App. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        // Simple character counter for the content field
        document.addEventListener('DOMContentLoaded', function() {
            const contentField = document.getElementById('content');
            const charCount = document.createElement('div');
            charCount.className = 'text-sm text-gray-500 mt-1 text-right';
            contentField.parentNode.appendChild(charCount);

            function updateCharCount() {
                const count = contentField.value.length;
                charCount.textContent = `${count} characters`;

                if (count > 500) {
                    charCount.classList.add('text-red-500');
                    charCount.classList.remove('text-gray-500');
                } else {
                    charCount.classList.remove('text-red-500');
                    charCount.classList.add('text-gray-500');
                }
            }

            contentField.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
        });
    </script>
</body>
</html>
