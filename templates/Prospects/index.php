<?php $total = $this->Paginator->param('count'); ?>

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
.btn-add {
    display: inline-flex; align-items: center; gap: 6px;
    background: #1d4ed8; color: #fff; border: none; border-radius: 8px;
    padding: 9px 18px; font-size: 13px; font-weight: 600;
    text-decoration: none; cursor: pointer; transition: background .15s;
}
.btn-add:hover { background: #1e40af; color: #fff; }
.stats {
    display: grid; grid-template-columns: repeat(5, 1fr);
    gap: 10px; margin-bottom: 1rem;
}
.stat {
    background: #f9fafb; border: 0.5px solid #e5e7eb;
    border-radius: 10px; padding: 14px 16px;
}
.stat-label {
    font-size: 11px; color: #6b7280; text-transform: uppercase;
    letter-spacing: .06em; margin-bottom: 6px;
}
.stat-value { font-size: 24px; font-weight: 700; color: #111827; }
.crm-card {
    background: #fff; border: 0.5px solid #e5e7eb;
    border-radius: 12px; overflow: hidden;
}
.toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 16px; border-bottom: 0.5px solid #e5e7eb;
    flex-wrap: wrap; gap: 8px;
}
.search-wrap {
    display: flex; align-items: center; gap: 8px;
    background: #f9fafb; border: 0.5px solid #e5e7eb;
    border-radius: 8px; padding: 0 12px; width: 260px;
}
.search-wrap i { color: #9ca3af; font-size: 15px; }
.search-wrap input {
    background: transparent; border: none; outline: none;
    font-size: 13px; color: #111827; padding: 7px 0; width: 100%;
}
.filter-group { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
.filter-btn {
    display: inline-flex; align-items: center; gap: 5px;
    background: transparent; border: 0.5px solid #d1d5db;
    border-radius: 8px; padding: 6px 12px; font-size: 12px;
    color: #6b7280; cursor: pointer; transition: .15s;
    text-decoration: none; font-family: inherit;
}
.filter-btn:hover { background: #f3f4f6; color: #111827; }
select.filter-btn { padding: 7px 12px; }
table { width: 100%; border-collapse: collapse; }
thead tr { background: #f9fafb; }
th {
    font-size: 11px; text-transform: uppercase; letter-spacing: .06em;
    color: #6b7280; font-weight: 500; padding: 11px 14px;
    text-align: left; white-space: nowrap; border-bottom: 0.5px solid #e5e7eb;
}
td {
    padding: 12px 14px; font-size: 13px; color: #111827;
    border-bottom: 0.5px solid #f3f4f6; white-space: nowrap;
}
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover { background: #f8faff; }
.id      { color: #9ca3af; font-size: 12px; font-family: monospace; }
.company { font-weight: 600; }
.link    { color: #2563eb; text-decoration: none; }
.link:hover { text-decoration: underline; }
.badge-soft {
    display: inline-flex; align-items: center;
    padding: 3px 10px; border-radius: 999px;
    font-size: 11px; font-weight: 600;
}
.b-new     { background: #dbeafe; color: #1d4ed8; }
.b-pending { background: #fef3c7; color: #92400e; }
.b-won     { background: #dcfce7; color: #166534; }
.b-lost    { background: #fee2e2; color: #991b1b; }
.b-default { background: #e5e7eb; color: #374151; }
.actions { display: flex; justify-content: flex-end; gap: 5px; }
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px;
    border: 0.5px solid #d1d5db; background: transparent;
    cursor: pointer; color: #6b7280; font-size: 14px;
    text-decoration: none; transition: .15s;
}
.act-btn:hover        { background: #f3f4f6; color: #111827; }
.act-btn.danger:hover { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
.empty-row td { text-align: center; color: #9ca3af; padding: 2.5rem 1rem; font-size: 13px; }
.filter-active-bar {
    padding: 8px 16px; border-bottom: 0.5px solid #e5e7eb;
    background: #f0f7ff; font-size: 12px; color: #374151;
    display: flex; align-items: center; gap: 6px;
}
.filter-badge {
    display: inline-flex; align-items: center;
    background: #dbeafe; color: #1d4ed8;
    border-radius: 999px; padding: 2px 10px;
    font-size: 11px; font-weight: 600;
}
.tbl-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 16px; border-top: 0.5px solid #e5e7eb;
}
.footer-info { font-size: 12px; color: #6b7280; }
.pagination  { display: flex; gap: 4px; list-style: none; margin: 0; padding: 0; }
.pagination li a,
.pagination li span {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 30px; height: 30px; border-radius: 7px;
    border: 0.5px solid #e5e7eb; background: transparent;
    font-size: 12px; color: #6b7280; padding: 0 6px; text-decoration: none;
}
.pagination li.active a,
.pagination li.active span { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
.pagination li a:hover { background: #f3f4f6; }

/* ── Dark Mode ── */
body.dark-mode .topbar              { background: #1a1a1a; border-color: #2d2d2d; }
body.dark-mode .topbar h2           { color: #ffffff; }
body.dark-mode .topbar p            { color: #9ca3af; }
body.dark-mode .stat                { background: #1a1a1a; border-color: #2d2d2d; }
body.dark-mode .stat-label          { color: #9ca3af; }
body.dark-mode .stat-value          { color: #ffffff; }
body.dark-mode .crm-card            { background: #1a1a1a; border-color: #2d2d2d; }
body.dark-mode .toolbar             { border-color: #2d2d2d; }
body.dark-mode .search-wrap         { background: #252525; border-color: #444444; }
body.dark-mode .search-wrap input   { color: #ffffff; }
body.dark-mode .search-wrap input::placeholder { color: #6b7280; }
body.dark-mode .filter-btn          { border-color: #444444; color: #e5e7eb; }
body.dark-mode .filter-btn:hover    { background: #333333; color: #ffffff; }
body.dark-mode select.filter-btn    { background: #252525; color: #e5e7eb; }
body.dark-mode .filter-active-bar   { background: #1a1a2e; border-color: #2d2d2d; color: #e5e7eb; }
body.dark-mode thead tr             { background: #111111; }
body.dark-mode th                   { color: #9ca3af; border-color: #2d2d2d; }
body.dark-mode td                   { color: #e5e7eb; border-color: #2d2d2d; }
body.dark-mode tbody tr:hover       { background: #252525; }
body.dark-mode .id                  { color: #6b7280; }
body.dark-mode .company             { color: #ffffff; }
body.dark-mode .link                { color: #60a5fa; }
body.dark-mode .act-btn             { border-color: #444444; color: #9ca3af; }
body.dark-mode .act-btn:hover       { background: #333333; color: #ffffff; }
body.dark-mode .tbl-footer          { border-color: #2d2d2d; }
body.dark-mode .footer-info         { color: #9ca3af; }
body.dark-mode .pagination li a,
body.dark-mode .pagination li span  { border-color: #444444; color: #9ca3af; background: #1a1a1a; }
body.dark-mode .pagination li a:hover { background: #333333; color: #ffffff; }
body.dark-mode .pagination li.active a,
body.dark-mode .pagination li.active span { background: #1d4ed8; border-color: #1d4ed8; color: #ffffff; }

/* ===== Badges Statut - Dark Mode ===== */

body.dark-mode .b-new{
    background:#1e3a8a;
    color:#bfdbfe;
}

body.dark-mode .b-pending{
    background:#78350f;
    color:#fde68a;
}

body.dark-mode .b-won{
    background:#14532d;
    color:#bbf7d0;
}

body.dark-mode .b-lost{
    background:#7f1d1d;
    color:#fecaca;
}

body.dark-mode .b-default{
    background:#374151;
    color:#e5e7eb;
}
</style>

<div class="page">

    <div class="topbar">
        <div>
            <h2>Prospects</h2>
            <p>Gestion des leads commerciaux</p>
        </div>
      <?php if ($authUser && $authUser->role === 'admin'): ?>

<?= $this->Html->link(
    '<i class="bi bi-plus-lg"></i> Nouveau prospect',
    ['action' => 'add'],
    ['class' => 'btn-add', 'escape' => false]
) ?>

<?php endif; ?>
    </div>

    <div class="stats">
        <?php foreach ($statuses as $key => $libelle): ?>
            <div class="stat">
                <div class="stat-label"><?= h($libelle) ?></div>
                <div class="stat-value"><?= $stats[$key] ?? 0 ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="crm-card">

        <form id="filterForm" method="get" action="<?= $this->Url->build(['action' => 'index']) ?>">
            <div class="toolbar">
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search"
                        value="<?= h($search ?? '') ?>"
                        placeholder="Rechercher un prospect…" />
                </div>
                <div class="filter-group">
                    <select name="status" class="filter-btn" onchange="document.getElementById('filterForm').submit();">
                    <option value="">Tous les statuts</option>
                    <?php foreach ($statuses as $key => $libelle): ?>
                        <option value="<?= h($key) ?>" <?= ($status ?? '') === $key ? 'selected' : '' ?>>
                            <?= h($libelle) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                                    
                    <?= $this->Html->link(
                        '<i class="bi bi-sort-alpha-down"></i> Croissant',
                        ['?' => array_filter(['search' => $search, 'status' => $status, 'sort' => 'asc'])],
                        ['class' => 'filter-btn' . ($sort === 'asc' ? ' active' : ''), 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="bi bi-sort-alpha-up"></i> Décroissant',
                        ['?' => array_filter(['search' => $search, 'status' => $status, 'sort' => 'desc'])],
                        ['class' => 'filter-btn' . ($sort === 'desc' ? ' active' : ''), 'escape' => false]
                    ) ?>
                    <?php if (!empty($search) || !empty($status) || !empty($sort)): ?>
                        <?= $this->Html->link(
                            '<i class="bi bi-x-circle"></i> Réinitialiser',
                            ['action' => 'index'],
                            ['class' => 'filter-btn', 'escape' => false,
                             'style' => 'color:#ef4444;border-color:#fca5a5;']
                        ) ?>
                    <?php endif; ?>
                    <?= $this->Html->link(
                        '<i class="bi bi-download"></i> Export CSV',
                        [
                            'action' => 'export',
                            '?' => array_filter([
                                'search' => $search,
                                'status' => $status,
                                'sort'   => $sort
                            ])
                        ],
                        ['class' => 'filter-btn', 'escape' => false]
                    ) ?>
                </div>
            </div>
        </form>

        <?php if (!empty($status) && isset($statuses[$status])): ?>
            <div class="filter-active-bar">
                <i class="bi bi-funnel-fill" style="color:#1d4ed8;"></i>
                Filtre actif :
                <span class="filter-badge"><?= h($statuses[$status]) ?></span>
                — <?= $total ?> résultat<?= $total > 1 ? 's' : '' ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Entreprise</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Ville</th>
                        <th>Statut</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total === 0): ?>
                        <tr class="empty-row">
                            <td colspan="8">
                                <i class="bi bi-inbox" style="font-size:24px;display:block;margin-bottom:6px;"></i>
                                Aucun prospect trouvé<?= !empty($status) ? ' pour ce statut' : '' ?>.
                                <?php if (!empty($status) || !empty($search)): ?>
                                    <?= $this->Html->link('Voir tous', ['action' => 'index'], ['style' => 'color:#2563eb;font-weight:600;']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($prospects as $p): ?>
                            <?php
                                $s       = strtolower((string)$p->status);
                                $badge   = match($s) {
                                    'new'         => 'b-new',
                                    'contacted'   => 'b-pending',
                                    'in_progress' => 'b-pending',
                                    'client'      => 'b-won',
                                    'lost'        => 'b-lost',
                                    default       => 'b-default'
                                };
                                $libelle = $statuses[$s] ?? $p->status;
                            ?>
                            <tr>
                                <td><span class="id">#<?= h($p->id) ?></span></td>
                                <td class="company"><?= h($p->company_name) ?></td>
                                <td><?= h($p->contact_name) ?></td>
                                <td><a href="mailto:<?= h($p->email) ?>" class="link"><?= h($p->email) ?></a></td>
                                <td><a href="tel:<?= h($p->phone) ?>" class="link"><?= h($p->phone) ?></a></td>
                                <td><?= h($p->city) ?></td>
                                <td>
                                    <?php if ($s === 'client' && !empty($p->client)): ?>
                                        <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'view', $p->client->id]) ?>" class="text-decoration-none">
                                            <span class="badge-soft <?= $badge ?>"><?= h($libelle) ?></span>
                                        </a>
                                    <?php else: ?>
                                        <span class="badge-soft <?= $badge ?>"><?= h($libelle) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                   <div class="actions">

    <?= $this->Html->link(
        '<i class="bi bi-eye"></i>',
        ['action' => 'view', $p->id],
        [
            'class' => 'act-btn',
            'escape' => false,
            'title' => 'Voir'
        ]
    ) ?>

    <?php if ($authUser && $authUser->role === 'admin'): ?>

        <?= $this->Html->link(
            '<i class="bi bi-pencil"></i>',
            ['action' => 'edit', $p->id],
            [
                'class' => 'act-btn',
                'escape' => false,
                'title' => 'Modifier'
            ]
        ) ?>

        <?= $this->Form->postLink(
            '<i class="bi bi-trash"></i>',
            ['action' => 'delete', $p->id],
            [
                'class' => 'act-btn danger',
                'escape' => false,
                'title' => 'Supprimer',
                'confirm' => 'Supprimer ce prospect ?'
            ]
        ) ?>

    <?php endif; ?>

    <?= $this->Html->link(
        '<i class="bi bi-file-earmark-pdf"></i>',
        ['action' => 'viewPdf', $p->id],
        [
            'class' => 'act-btn pdf',
            'escape' => false,
            'title' => 'Télécharger PDF'
        ]
    ) ?>

</div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="tbl-footer">
            <span class="footer-info">
                <?= $total ?> prospect<?= $total > 1 ? 's' : '' ?>
                <?= !empty($status) && isset($statuses[$status]) ? ' — <strong>' . h($statuses[$status]) . '</strong>' : '' ?>
            </span>
            <ul class="pagination">
                <?= $this->Paginator->prev('<i class="bi bi-chevron-left"></i>',  ['escape' => false]) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('<i class="bi bi-chevron-right"></i>', ['escape' => false]) ?>
            </ul>
        </div>

    </div>
</div>
