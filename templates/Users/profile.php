<style>
body{
    background:#f5f7fb;
}

.profile-container{
    max-width:800px;
    margin:auto;
}

.profile-title{
    font-size:28px;
    font-weight:700;
    color:#1f2937;
    margin-bottom:20px;
}

.profile-card{
    background:#fff;
    border:1px solid #e3e6f0;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.profile-header{
    background:linear-gradient(135deg,#2563eb,#1e40af);
    color:#fff;
    text-align:center;
    padding:30px;
}

.profile-avatar{
    width:90px;
    height:90px;
    border-radius:50%;
    background:#fff;
    color:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:45px;
    margin:0 auto 15px;
}

.profile-header h3{
    margin:0;
    font-weight:600;
}

.profile-header p{
    margin:5px 0 0;
    opacity:.8;
}

.profile-table{
    margin-bottom:0;
}

.profile-table th{
    width:220px;
    background:#f8fafc;
    color:#374151;
    font-weight:600;
    padding:15px;
}

.profile-table td{
    padding:15px;
    color:#111827;
}

.profile-table tr:hover{
    background:#f9fafb;
}

.badge-role{
    background:#dbeafe;
    color:#1d4ed8;
    padding:6px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.card-footer{
    background:#fff;
    border-top:1px solid #e5e7eb;
}

/* ---------- DARK MODE ---------- */

body.dark-mode{
    background:#1a1a1a;
    color:#f8fafc;
}

body.dark-mode .profile-title{
    color:#fff;
}

body.dark-mode .profile-card{
    background:#212529;
    border:1px solid #343a40;
    box-shadow:0 4px 20px rgba(0,0,0,.5);
}

body.dark-mode .profile-header{
    background:linear-gradient(135deg,#1e293b,#0f172a);
}

body.dark-mode .profile-avatar{
    background:#1f2937;
    color:#60a5fa;
    border:2px solid #374151;
}

body.dark-mode .profile-table th{
    background:#1a1a1a;
    color:#fff;
    border-color:#374151;
}

body.dark-mode .profile-table td{
    background:#1a1a1a;
    color:#e5e7eb;
    border-color:#374151;
}

body.dark-mode .profile-table tr:hover th,
body.dark-mode .profile-table tr:hover td{
    background:#302b2b;
}

body.dark-mode .badge-role{
    background:#2563eb;
    color:#fff;
}

body.dark-mode .card-footer{
    background:#212529;
    border-top:1px solid #343a40;
}

body.dark-mode .btn-edit{
    background:#2563eb;
    color:#fff;
    border:1px solid #60a5fa;
}

body.dark-mode .btn-edit:hover{
    background:#2563eb;
    color:#fff;
    border-color:#3b82f6;
}
</style>

<div class="container mt-4 profile-container">

    <h2 class="profile-title">
        <i class="bi bi-person-circle"></i> Mon Profil
    </h2>

    <div class="card profile-card">

        <div class="profile-header">

            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <h3><?= h($userData->firstname . ' ' . $userData->lastname) ?></h3>

            <p><?= h($userData->email) ?></p>

        </div>

        <div class="card-body p-0">

            <table class="table profile-table">
                <tbody>

                    <tr>
                        <th>ID</th>
                        <td><?= h($userData->id) ?></td>
                    </tr>

                    <tr>
                        <th>Prénom</th>
                        <td><?= h($userData->firstname) ?></td>
                    </tr>

                    <tr>
                        <th>Nom</th>
                        <td><?= h($userData->lastname) ?></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><?= h($userData->email) ?></td>
                    </tr>

                    <tr>
                        <th>Rôle</th>
                        <td>
                            <span class="badge-role">
                                <?= h($userData->role) ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Créé le</th>
                        <td><?= h($userData->created) ?></td>
                    </tr>

                </tbody>
            </table>

        </div>

        <div class="card-footer text-end p-3">
            <?php if ($authUser  ): ?>

            <?= $this->Html->link(
                '<i class="bi bi-pencil-square"></i> Modifier',
                ['action' => 'edit', $userData->id],
                [
                    'class' => 'btn btn-primary btn-edit',
                    'escape' => false
                ]
            ) ?>
            <?php endif; ?>
        </div>

    </div>

</div>