<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf @method('PUT')
        <label>Title</label>
        <input type="text" name="title" value="{{ $post->title }}"><br>
        <label>Content</label>
        <textarea name="content">{{ $post->content }}</textarea><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
