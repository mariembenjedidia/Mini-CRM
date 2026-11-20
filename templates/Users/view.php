<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<style>
* { box-sizing: border-box; }
.page { padding: 0 0 1.5rem; }
.topbar {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1.25rem 1.5rem; background: #fff;
    border: 0.5px solid #e5e7eb; border-radius: 12px; margin-bottom: 1rem;
}
.topbar h2 { font-size: 20px; font-weight: 600; margin: 0; color: #111827; }
.topbar p  { font-size: 13px; color: #6b7280; margin: 2px 0 0; }
.topbar-actions { display: flex; gap: 8px; }
.btn-action {
    display: inline-flex; align-items: center; gap: 6px;
    border-radius: 8px; padding: 9px 16px; font-size: 13px; font-weight: 600;
    text-decoration: none; cursor: pointer; transition: .15s; border: none;
}
.btn-back    { background: #f3f4f6; color: #374151; }
.btn-back:hover { background: #e5e7eb; color: #111827; }
.btn-edit    { background: #1d4ed8; color: #fff; }
.btn-edit:hover { background: #1e40af; color: #fff; }
.btn-delete  { background: #fee2e2; color: #991b1b; }
.btn-delete:hover { background: #fecaca; color: #7f1d1d; }

.crm-card {
    background: #fff; border: 0.5px solid #e5e7eb;
    border-radius: 12px; overflow: hidden;
}
.section-title {
    font-size: 11px; text-transform: uppercase; letter-spacing: .06em;
    color: #6b7280; font-weight: 600; padding: 14px 20px;
    border-bottom: 0.5px solid #e5e7eb; background: #f9fafb;
}
.info-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 0;
}
.info-item {
    padding: 16px 20px; border-bottom: 0.5px solid #f3f4f6;
}
.info-item:nth-child(odd)  { border-right: 0.5px solid #f3f4f6; }
.info-label {
    font-size: 11px; color: #6b7280; text-transform: uppercase;
    letter-spacing: .06em; margin-bottom: 4px;
}
.info-value {
    font-size: 14px; color: #111827; font-weight: 500;
}
.info-value a { color: #2563eb; text-decoration: none; }
.info-value a:hover { text-decoration: underline; }

.badge-soft {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 999px;
    font-size: 11px; font-weight: 600;
}
.b-admin { background: #fee2e2; color: #991b1b; }
.b-user  { background: #dcfce7; color: #166534; }

.avatar-wrap {
    display: flex; flex-direction: column; align-items: center;
    padding: 2rem 1rem; border-bottom: 0.5px solid #f3f4f6;
}
.avatar {
    width: 72px; height: 72px; border-radius: 50%;
    background: #dbeafe; color: #1d4ed8;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; font-weight: 700; margin-bottom: 10px;
}
.avatar-name { font-size: 16px; font-weight: 600; color: #111827; }
.avatar-email { font-size: 12px; color: #6b7280; margin-top: 2px; }

/* Dark Mode */
body.dark-mode .topbar         { background: #1a1a1a; border-color: #2d2d2d; }
body.dark-mode .topbar h2      { color: #fff; }
body.dark-mode .topbar p       { color: #9ca3af; }
body.dark-mode .btn-back       { background: #2d2d2d; color: #e5e7eb; }
body.dark-mode .btn-back:hover { background: #3a3a3a; color: #fff; }
body.dark-mode .crm-card       { background: #1a1a1a; border-color: #2d2d2d; }
body.dark-mode .section-title  { background: #111; border-color: #2d2d2d; color: #9ca3af; }
body.dark-mode .info-item      { border-color: #2d2d2d; }
body.dark-mode .info-item:nth-child(odd) { border-color: #2d2d2d; }
body.dark-mode .info-label     { color: #9ca3af; }
body.dark-mode .info-value     { color: #e5e7eb; }
body.dark-mode .info-value a   { color: #60a5fa; }
body.dark-mode .avatar         { background: #1e3a8a; color: #bfdbfe; }
body.dark-mode .avatar-name    { color: #fff; }
body.dark-mode .avatar-email   { color: #9ca3af; }
body.dark-mode .b-admin        { background: #7f1d1d; color: #fecaca; }
body.dark-mode .b-user         { background: #14532d; color: #bbf7d0; }
</style>

<div class="page">

    <div class="topbar">
        <div>
            <h2>Fiche utilisateur</h2>
            <p>Détails du compte #<?= h($user->id) ?></p>
        </div>
      
    </div>

    <div class="crm-card">

        <!-- Avatar -->
        <div class="avatar-wrap">
            <div class="avatar">
                <?= strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1)) ?>
            </div>
            <div class="avatar-name"><?= h($user->firstname . ' ' . $user->lastname) ?></div>
            <div class="avatar-email"><?= h($user->email) ?></div>
            <div class="mt-2">
                <?php if ($user->role === 'admin'): ?>
                    <span class="badge-soft b-admin"><i class="bi bi-shield-fill"></i> Admin</span>
                <?php else: ?>
                    <span class="badge-soft b-user"><i class="bi bi-person-fill"></i> User</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="section-title">Informations</div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Prénom</div>
                <div class="info-value"><?= h($user->firstname) ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Nom</div>
                <div class="info-value"><?= h($user->lastname) ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value">
                    <a href="mailto:<?= h($user->email) ?>"><?= h($user->email) ?></a>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Rôle</div>
                <div class="info-value">
                    <?php if ($user->role === 'admin'): ?>
                        <span class="badge-soft b-admin"><i class="bi bi-shield-fill"></i> Admin</span>
                    <?php else: ?>
                        <span class="badge-soft b-user"><i class="bi bi-person-fill"></i> User</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">ID</div>
                <div class="info-value" style="font-family:monospace;color:#9ca3af;">#<?= h($user->id) ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Créé le</div>
                <div class="info-value"><?= h($user->created->format('d/m/Y à H:i')) ?></div>
            </div>
        </div>

    </div>
</div>