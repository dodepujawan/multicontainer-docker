<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<!-- Header -->
<nav class="navbar navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <h1 class="h4 my-2">Create New Post</h1>
        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</nav>

<!-- Main -->
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="postForm">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Enter post title" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea id="content" name="content" rows="5" class="form-control" placeholder="Write your content..."></textarea>
                            <div id="char-count" class="form-text text-muted mt-1">0 characters</div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                            <button type="submit" id="submitBtn" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> <span id="submitText">Create & Print</span>
                            </button>
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="row mt-4 g-3">
                <div class="col-md-6">
                    <div class="card border-info">
                        <div class="card-body text-info">
                            <h6><i class="fas fa-lightbulb me-2"></i> Writing Tips</h6>
                            <ul class="small mb-0">
                                <li>Use a clear, descriptive title</li>
                                <li>Write short paragraphs</li>
                                <li>Proofread before publishing</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-body text-primary">
                            <h6><i class="fas fa-magic me-2"></i> Formatting Help</h6>
                            <ul class="small mb-0">
                                <li>Use <b>bold</b> for emphasis</li>
                                <li>Add bullet points</li>
                                <li>Include subheadings if long</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-white border-top py-3 mt-auto">
    <div class="container text-center text-muted small">
        &copy; {{ date('Y') }} Posts App. All rights reserved.
    </div>
</footer>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JSPrintManager -->
<script src="https://cdn.jsdelivr.net/npm/jsprintmanager@8/binaries/0.0.0.8/JSPM.js"></script>
<script src="https://unpkg.com/jsprintmanager/JSPrintManager.js"></script>

<script>
$(document).ready(function() {
    // Pastikan JSPM terdefinisi
    if (typeof JSPM === 'undefined') {
        alert("⚠️ JSPrintManager belum dimuat. Pastikan Anda menginstal aplikasi JSPrintManager di komputer ini.");
        return;
    }

    // Start JSPrintManager
    JSPM.JSPrintManager.start()
        .then(() => console.log("✅ JSPrintManager Ready!"))
        .catch(e => {
            console.error("JSPrintManager Error:", e);
            alert("❌ JSPrintManager belum siap. Pastikan aplikasi JSPrintManager sedang berjalan.");
        });

    // Character counter
    $('#content').on('input', function() {
        $('#char-count').text($(this).val().length + ' characters');
    });

    // Form Submit AJAX
    $('#postForm').on('submit', function(e) {
        e.preventDefault(); // <== ini penting, biar form tidak reload!

        let btn = $('#submitBtn');
        let btnText = $('#submitText');
        btn.prop('disabled', true);
        btnText.text('Creating...');

        $.ajax({
            url: '{{ route('posts.store') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                title: $('#title').val(),
                content: $('#content').val()
            },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    printStruk(res.print_data);
                    setTimeout(() => {
                        window.location.href = '{{ route('posts.index') }}';
                    }, 2000);
                } else {
                    alert('Failed to create post');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Error creating post');
                btn.prop('disabled', false);
                btnText.text('Create & Print');
            }
        });
    });

    // Fungsi print
    function printStruk(printData) {
        try {
            let escpos = '\x1B\x40' + printData + '\n\n\n\x1B\x69';
            let printer = new JSPM.ClientPrint();
            printer.printerCommands = escpos;

            printer.sendToClient()
                .then(() => alert("Post created & printed successfully!"))
                .catch(e => alert("Print failed: " + e.message));
        } catch (err) {
            console.error(err);
            alert("Print error: " + err.message);
        }
    }
});
</script>
</body>
</html>
