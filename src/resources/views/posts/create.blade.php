<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Create New Post</h1>
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
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf

                    <!-- Title Field -->
                    <div class="mb-6">
                        <label for="title" class="block text-gray-700 font-medium mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                               placeholder="Enter a compelling title for your post"
                               required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content Field -->
                    <div class="mb-8">
                        <label for="content" class="block text-gray-700 font-medium mb-2">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content"
                                  name="content"
                                  rows="8"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                                  placeholder="Write your post content here...">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-sm text-gray-500">Minimum 50 characters recommended</p>
                            <p id="char-count" class="text-sm text-gray-500">0 characters</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg flex items-center justify-center transition duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-plus-circle mr-2"></i> Create Post
                        </button>
                        <a href="{{ route('posts.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg flex items-center justify-center transition duration-200">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Writing Tips Section -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tips Card -->
                <div class="bg-blue-50 rounded-lg p-5 border border-blue-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-blue-500 text-lg mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-blue-800 mb-2">Writing Tips</h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Write a clear, descriptive title</li>
                                <li>• Start with a strong introduction</li>
                                <li>• Use paragraphs to break up content</li>
                                <li>• Proofread before publishing</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Formatting Card -->
                <div class="bg-purple-50 rounded-lg p-5 border border-purple-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-magic text-purple-500 text-lg mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-purple-800 mb-2">Formatting Help</h3>
                            <ul class="text-sm text-purple-700 space-y-1">
                                <li>• Use **bold** for emphasis</li>
                                <li>• Add bullet points for lists</li>
                                <li>• Include subheadings for long posts</li>
                                <li>• Add images to enhance content</li>
                            </ul>
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
        // Character counter and validation for the content field
        document.addEventListener('DOMContentLoaded', function() {
            const contentField = document.getElementById('content');
            const charCount = document.getElementById('char-count');
            const submitButton = document.querySelector('button[type="submit"]');

            function updateCharCount() {
                const count = contentField.value.length;
                charCount.textContent = `${count} characters`;

                // Visual feedback based on content length
                if (count < 10) {
                    charCount.classList.add('text-red-500');
                    charCount.classList.remove('text-yellow-500', 'text-green-500');
                } else if (count < 50) {
                    charCount.classList.add('text-yellow-500');
                    charCount.classList.remove('text-red-500', 'text-green-500');
                } else {
                    charCount.classList.add('text-green-500');
                    charCount.classList.remove('text-red-500', 'text-yellow-500');
                }
            }

            contentField.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count

            // Basic form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const title = document.getElementById('title').value.trim();
                const content = contentField.value.trim();

                if (!title) {
                    e.preventDefault();
                    alert('Please enter a title for your post');
                    document.getElementById('title').focus();
                    return;
                }

                if (!content) {
                    e.preventDefault();
                    alert('Please enter content for your post');
                    contentField.focus();
                    return;
                }

                if (content.length < 5) {
                    e.preventDefault();
                    alert('Please write more content for your post (minimum 5 characters)');
                    contentField.focus();
                    return;
                }
            });
        });
    </script>
</body>
</html>
