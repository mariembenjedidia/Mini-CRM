<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM Pro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* HEADER */
        .crm-header {
            height: 60px;
            background: #111827;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .crm-logo {
            font-weight: bold;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* LAYOUT */
        .crm-wrapper {
            display: flex;
            flex: 1;
        }

        /* SIDEBAR */
        .crm-sidebar {
            width: 220px;
            background: #1f2937;
            padding: 15px;
            flex-shrink: 0;
        }

        .crm-sidebar a {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #d1d5db;
            padding: 10px;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 4px;
            transition: 0.2s;
        }

        .crm-sidebar a:hover,
        .crm-sidebar a.active {
            background: #374151;
            color: white;
        }

        /* CONTENT */
        .crm-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        /* FOOTER */
        .crm-footer {
            background: #111827;
            color: #9ca3af;
            text-align: center;
            padding: 10px;
            font-size: 13px;
        }
        @media (max-width: 768px) {

    .crm-wrapper {
        flex-direction: column;
    }

    .crm-sidebar {
        width: 100%;
        display: flex;
        overflow-x: auto;
    }

    .crm-content {
        padding: 10px;
    }

}
    </style>
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="crm-header">

    <!-- LOGO -->
    <a href="<?= $this->Url->build(['controller' => 'Prospects', 'action' => 'index']) ?>" class="crm-logo text-white text-decoration-none">
        <i class="bi bi-graph-up-arrow"></i>
        CRM Pro
    </a>

    <!-- RIGHT MENU -->
    <div class="d-flex gap-2">

        <!-- DARK MODE -->
        <button id="theme-toggle" class="btn btn-sm btn-outline-light">
            <i class="bi bi-moon-fill"></i>
        </button>

        <!-- PROFILE -->
        <?= $this->Html->link(
    '<i class="bi bi-person-circle"></i> Profile',
    ['controller' => 'Users', 'action' => 'profile'],
    [
        'class' => 'btn btn-sm btn-outline-light',
        'escape' => false
    ]
) ?>

        <!-- LOGOUT -->
        <?= $this->Form->postLink(
            '<i class="bi bi-box-arrow-right"></i> Logout',
            ['controller' => 'Users', 'action' => 'logout'],
            [
                'class' => 'btn btn-sm btn-danger',
                'escape' => false
            ]
        ) ?>

    </div>

</header>

<!-- ================= BODY ================= -->
<div class="crm-wrapper">

    <!-- SIDEBAR -->
    <aside class="crm-sidebar">
      <?php $authUser = $this->request->getAttribute('identity'); ?>

<?php if ($authUser && $authUser->role === 'admin'): ?>

<?= $this->Html->link('Dashboard', [
    'controller' => 'Dashboard',
    'action' => 'index'
]) ?>

<?php endif; ?>

        <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'index']) ?>">
            <i class="bi bi-speedometer2"></i> Users
        </a>
        <a href="<?= $this->Url->build(['controller' => 'Prospects', 'action' => 'index']) ?>">
            <i class="bi bi-people"></i> Prospects
        </a>

        <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'index']) ?>">
            <i class="bi bi-briefcase"></i> Clients
        </a>
        <a href="<?= $this->Url->build(['controller' => 'Calls', 'action' => 'index']) ?>">
            <i class="bi bi-telephone"></i> Calls
        </a>
       

        <a href="<?= $this->Url->build(['controller' => 'Chatbot', 'action' => 'index']) ?>">
            <i class="bi bi-robot"></i> Chatbot 
        </a>

    </aside>

    <!-- CONTENT -->
    <main class="crm-content">
        <?= $this->fetch('content') ?>
    </main>

</div>

<!-- ================= FOOTER ================= -->
<footer class="crm-footer">
    &copy; <?= date('Y') ?> CRM Pro — All rights reserved
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<style>
  /* ================= DARK MODE ================= */

body.dark-mode {
    background: #0d0d0d;
    color: #ffffff;
}

body.dark-mode .crm-header {
    background: #000000;
    color: #ffffff;
}

body.dark-mode .crm-sidebar {
    background: #111111;
    color: #ffffff;
}

body.dark-mode .crm-content {
    background: #0d0d0d;
    color: #ffffff;
}

body.dark-mode .crm-footer {
    background: #000000;
    color: #ffffff;
    border-color: #333333;
}

/* ── Sidebar links ── */
body.dark-mode .crm-sidebar a {
    color: #e5e7eb;
}

body.dark-mode .crm-sidebar a:hover,
body.dark-mode .crm-sidebar a.active {
    background: #fc4747;
    color: #ffffff;
}

/* ── Cards ── */
body.dark-mode .card,
body.dark-mode .crm-card {
    background: #1a1a1a;
    color: #ffffff;
    border-color: #2d2d2d;
}

body.dark-mode .card-header {
    background: #111111;
    color: #ffffff;
    border-color: #2d2d2d;
}

body.dark-mode .card-body {
    background: #1a1a1a;
    color: #ffffff;
}

/* ── Stat cards text ── */
body.dark-mode .text-gray-800 {
    color: #ffffff !important;
}

body.dark-mode .text-gray-300 {
    color: #6b7280 !important;
}

/* ── Table ── */
body.dark-mode table {
    background: #1a1a1a;
    color: #ffffff;
}

body.dark-mode th {
    background: #111111;
    color: #ffffff;
    border-color: #333333;
}

body.dark-mode td {
    color: #e5e7eb;
    border-color: #333333;
}

body.dark-mode tbody tr:hover {
    background: #252525;
}

/* ── Forms ── */
body.dark-mode input,
body.dark-mode select,
body.dark-mode textarea {
    background: #1a1a1a;
    color: #ffffff;
    border-color: #444444;
}

body.dark-mode input::placeholder,
body.dark-mode textarea::placeholder {
    color: #9ca3af;
}

body.dark-mode input:focus,
body.dark-mode select:focus,
body.dark-mode textarea:focus {
    background: #252525;
    color: #ffffff;
    border-color: #fc4747;
    box-shadow: 0 0 0 .2rem rgba(252, 71, 71, 0.25);
}

/* ── Headings & text ── */
body.dark-mode h1,
body.dark-mode h2,
body.dark-mode h3,
body.dark-mode h4,
body.dark-mode h5,
body.dark-mode h6 {
    color: #ffffff;
}

body.dark-mode .fw-bold {
    color: #ffffff;
}

body.dark-mode .text-muted {
    color: #9ca3af !important;
}

body.dark-mode p,
body.dark-mode label,
body.dark-mode span {
    color: #e5e7eb;
}

/* ── Buttons ── */
body.dark-mode .btn-outline-light {
    border-color: #6b7280;
    color: #ffffff;
}

body.dark-mode .btn-outline-secondary {
    border-color: #6b7280;
    color: #e5e7eb;
}

body.dark-mode .btn-outline-secondary:hover {
    background: #333333;
    color: #ffffff;
}

/* ── Badges & alerts ── */
body.dark-mode .badge {
    color: #ffffff;
}

body.dark-mode .alert {
    background: #1a1a1a;
    color: #ffffff;
    border-color: #333333;
}

/* ── Pagination ── */
body.dark-mode .page-link {
    background: #1a1a1a;
    color: #ffffff;
    border-color: #333333;
}

body.dark-mode .page-link:hover {
    background: #333333;
    color: #ffffff;
}

body.dark-mode .page-item.active .page-link {
    background: #fc4747;
    border-color: #fc4747;
    color: #ffffff;
}

/* ── Dropdown ── */
body.dark-mode .dropdown-menu {
    background: #1a1a1a;
    border-color: #333333;
}

body.dark-mode .dropdown-item {
    color: #e5e7eb;
}

body.dark-mode .dropdown-item:hover {
    background: #252525;
    color: #ffffff;
}

/* ── Chart cards ── */
body.dark-mode .chart-pie canvas,
body.dark-mode .chart-area canvas {
    filter: brightness(0.95);
}

/* ── Scrollbar ── */
body.dark-mode ::-webkit-scrollbar {
    width: 6px;
}

body.dark-mode ::-webkit-scrollbar-track {
    background: #111111;
}

body.dark-mode ::-webkit-scrollbar-thumb {
    background: #444444;
    border-radius: 3px;
}

body.dark-mode ::-webkit-scrollbar-thumb:hover {
    background: #fc4747;
}
</style>
<script>
const themeToggle = document.getElementById('theme-toggle');

if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    themeToggle.innerHTML = '<i class="bi bi-sun-fill"></i>';
}

themeToggle.addEventListener('click', () => {

    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {

        localStorage.setItem('theme', 'dark');

        themeToggle.innerHTML =
            '<i class="bi bi-sun-fill"></i>';

    } else {

        localStorage.setItem('theme', 'light');

        themeToggle.innerHTML =
            '<i class="bi bi-moon-fill"></i>';
    }
});
</script>