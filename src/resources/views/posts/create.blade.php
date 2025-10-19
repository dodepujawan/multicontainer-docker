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
{{-- <script src="https://cdn.jsdelivr.net/npm/jsprintmanager@8/binaries/0.0.0.8/JSPM.js"></script> --}}
<script src="https://unpkg.com/jsprintmanager/JSPrintManager.js"></script>

<script>
$(document).ready(function() {
    // Cek apakah JSPM sudah tersedia
    if (typeof JSPM === 'undefined') {
        alert("⚠️ JSPrintManager belum dimuat. Pastikan aplikasi JSPrintManager terinstall dan berjalan di komputer ini.");
        return;
    }

    // Set agar JSPrintManager otomatis reconnect
    JSPM.JSPrintManager.auto_reconnect = true;

    // Start JSPrintManager (pakai ws:// karena masih local)
    JSPM.JSPrintManager.start({
        websocket: { protocol: "ws", hostname: "localhost", port: 23443 }
    })
    .then(() => {
        console.log("✅ JSPrintManager started. Version:", JSPM.JSPrintManager.version);
        loadPrinters(); // opsional, untuk cek daftar printer
    })
    .catch(err => {
        console.error("❌ Tidak bisa konek ke JSPrintManager:", err);
        alert("❌ JSPrintManager tidak terhubung.\nPastikan aplikasinya sedang berjalan di tray Windows.");
    });

    // Fungsi untuk menampilkan daftar printer (opsional)
    async function loadPrinters() {
        try {
            const printers = await JSPM.JSPrintManager.getPrinters();
            console.log("🖨️ Printer yang terdeteksi:", printers);
        } catch (e) {
            console.error("Gagal ambil daftar printer:", e);
        }
    }

    // ===== Form Submit AJAX =====
    $('#postForm').on('submit', function(e) {
        e.preventDefault();

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
                    alert('Gagal membuat post.');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('❌ Error saat membuat post');
                btn.prop('disabled', false);
                btnText.text('Create & Print');
            }
        });
    });

    // ===== Fungsi cetak struk =====
    async function printStruk(printData) {
        try {
            // Pastikan koneksi JSPrintManager terbuka
            if (JSPM.JSPrintManager.websocket_status !== JSPM.WSStatus.Open) {
                console.warn("⚠️ WebSocket belum terbuka, mencoba start ulang...");
                await JSPM.JSPrintManager.start();
            }

            // Format ESC/POS dasar
            const escpos =
                '\x1B\x40' +                   // Initialize printer
                '\x1B\x61\x01' +               // Center
                'TOKO CONTOH\n' +
                '\x1B\x61\x00' +               // Left align
                '------------------------\n' +
                printData + '\n' +
                '------------------------\n' +
                '\n\n\n' +
                '\x1D\x56\x00';                // Full cut

            // Buat file teks untuk dikirim ke printer
            const file = new JSPM.PrintFileTXT(
                escpos,                        // Data ESC/POS
                JSPM.FileSourceType.Text,       // Tipe file
                "struk.txt",                    // Nama file
                1                               // Jumlah copy
            );

            // Buat job print baru (default printer)
            const pj = new JSPM.PrintJob();
            pj.files.push(file);

            // Kirim ke printer
            await pj.sendToClient();
            alert("✅ Struk berhasil dikirim ke printer!");

        } catch (err) {
            console.error("Print error:", err);
            alert("❌ Gagal mencetak: " + (err.message || err));
        } finally {
            $('#submitBtn').prop('disabled', false);
            $('#submitText').text('Create & Print');
        }
    }

    // Biar bisa dipanggil dari luar
    window.printStruk = printStruk;
});
</script>
</body>
</html>
