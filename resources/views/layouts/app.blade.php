<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --bg: #f4f1ea;
            --surface: rgba(255, 255, 255, 0.92);
            --border: #e5ddd1;
            --text: #102019;
            --muted: #6b7280;
            --sidebar: #0f1720;
            --sidebar-soft: rgba(255, 255, 255, 0.06);
            --accent: #c07b4e;
            --accent-strong: #ad6338;
        }

        html {
            font-family: 'Manrope', sans-serif;
        }

        body {
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(192, 123, 78, 0.18), transparent 28%),
                radial-gradient(circle at bottom right, rgba(16, 32, 25, 0.08), transparent 32%),
                linear-gradient(180deg, #f7f3ed 0%, var(--bg) 100%);
        }

        .content-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            box-shadow: 0 24px 60px rgba(15, 23, 32, 0.08);
            backdrop-filter: blur(10px);
        }

        .button-primary {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%);
            color: white;
            box-shadow: 0 12px 24px rgba(173, 99, 56, 0.24);
        }

        .button-secondary {
            background: #ede5db;
            color: #2b2b2b;
        }

        .button-danger {
            background: #b04848;
            color: white;
        }

        .table-frame {
            border-color: var(--border);
            background: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body class="min-h-screen text-slate-800">
    <div class="flex min-h-screen">
        <aside class="w-80 border-r border-white/10 bg-[var(--sidebar)] text-slate-200 shadow-2xl">
            <div class="border-b border-white/10 px-7 py-7">
                <div class="text-xs uppercase tracking-[0.35em] text-slate-500">UJK</div>
                <h1 class="mt-3 text-[1.7rem] font-extrabold leading-tight text-white">Kelola Perpustakaan</h1>
                <p class="mt-3 text-[0.95rem] leading-7 text-slate-400">Kelola anggota, buku, dan peminjaman dengan alur yang rapi.</p>
            </div>

            <nav class="space-y-2 px-5 py-7">
                <a href="{{ route('dashboard') }}" class="flex items-center rounded-2xl px-4 py-3.5 text-[0.98rem] font-semibold transition {{ ($activePage ?? '') === 'dashboard' ? 'bg-[var(--accent)] text-white shadow-lg shadow-black/20' : 'text-slate-300 hover:bg-[var(--sidebar-soft)] hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('anggota.index') }}" class="flex items-center rounded-2xl px-4 py-3.5 text-[0.98rem] font-semibold transition {{ ($activePage ?? '') === 'anggota' ? 'bg-[var(--accent)] text-white shadow-lg shadow-black/20' : 'text-slate-300 hover:bg-[var(--sidebar-soft)] hover:text-white' }}">
                    Anggota
                </a>
                <a href="{{ route('buku.index') }}" class="flex items-center rounded-2xl px-4 py-3.5 text-[0.98rem] font-semibold transition {{ ($activePage ?? '') === 'buku' ? 'bg-[var(--accent)] text-white shadow-lg shadow-black/20' : 'text-slate-300 hover:bg-[var(--sidebar-soft)] hover:text-white' }}">
                    Buku
                </a>
                <a href="{{ route('peminjaman.index') }}" class="flex items-center rounded-2xl px-4 py-3.5 text-[0.98rem] font-semibold transition {{ ($activePage ?? '') === 'peminjaman' ? 'bg-[var(--accent)] text-white shadow-lg shadow-black/20' : 'text-slate-300 hover:bg-[var(--sidebar-soft)] hover:text-white' }}">
                    Peminjaman
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-6 lg:p-10">
            <div class="mx-auto max-w-7xl">
                @yield('content')
            </div>
        </main>
    </div>

    <div id="deleteConfirmModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-900/60 p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <h3 class="text-xl font-semibold text-slate-900">Konfirmasi Hapus</h3>
            <p id="deleteConfirmMessage" class="mt-2 text-sm leading-6 text-slate-600">Apakah kamu yakin ingin menghapus data ini?</p>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" id="cancelDeleteBtn" class="rounded-md button-secondary px-4 py-2 text-sm font-medium">Batal</button>
                <button type="button" id="confirmDeleteBtn" class="rounded-md button-danger px-4 py-2 text-sm font-medium">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('deleteConfirmModal');
            const messageEl = document.getElementById('deleteConfirmMessage');
            const cancelBtn = document.getElementById('cancelDeleteBtn');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            let targetForm = null;

            const openModal = (form) => {
                targetForm = form;
                messageEl.textContent = form.dataset.confirmMessage || 'Apakah kamu yakin ingin menghapus data ini?';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const closeModal = () => {
                targetForm = null;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            document.querySelectorAll('form.js-delete-form').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    openModal(form);
                });
            });

            cancelBtn.addEventListener('click', closeModal);
            confirmBtn.addEventListener('click', () => {
                if (targetForm) {
                    targetForm.submit();
                }
            });

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        })();
    </script>
</body>
</html>