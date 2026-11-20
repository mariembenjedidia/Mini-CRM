<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-people-fill" style="color:#16a34a;"></i> Client
        </h2>
        <p class="text-muted mb-0">Détails de la fiche client</p>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <table class="table table-bordered align-middle mb-0 crm-form-table">

                <tbody>

                    <tr>
                        <th width="25%">ID Client</th>
                        <td><span class="text-muted">#<?= h($client->id) ?></span></td>
                    </tr>

                    <tr>
                        <th>Entreprise</th>
                        <td class="fw-bold"><?= h($client->company_name) ?></td>
                    </tr>

                    <tr>
                        <th>Nom du contact</th>
                        <td><?= h($client->contact_name) ?></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>
                            <?php if (!empty($client->email)) : ?>
                                <a href="mailto:<?= h($client->email) ?>" class="text-decoration-none">
                                    <i class="bi bi-envelope"></i> <?= h($client->email) ?>
                                </a>
                            <?php else : ?>
                                <span class="text-muted">Non renseigné</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Téléphone</th>
                        <td>
                            <?php if (!empty($client->phone)) : ?>
                                <a href="tel:<?= h($client->phone) ?>" class="text-decoration-none">
                                    <i class="bi bi-telephone"></i> <?= h($client->phone) ?>
                                </a>
                            <?php else : ?>
                                <span class="text-muted">Non renseigné</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Ville</th>
                        <td><?= h($client->city ?? '—') ?></td>
                    </tr>

                    <tr>
                        <th>Prospect d'origine</th>
                        <td>
                            <?php if (!empty($client->prospect)) : ?>
                                <?= $this->Html->link(
                                    '<i class="bi bi-person-bounding-box"></i> ' . h($client->prospect->company_name),
                                    ['controller' => 'Prospects', 'action' => 'view', $client->prospect->id],
                                    ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]
                                ) ?>
                            <?php else : ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Date de création</th>
                        <td>
                            <?= $client->created ? $client->created->format('d/m/Y H:i') : '—' ?>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!-- ACTIONS -->
        <div class="card-footer d-flex justify-content-between">

            <a href="<?= $this->Url->build(['action' => 'index']) ?>"
               class="btn btn-light">
                <i class="bi bi-arrow-left"></i> Retour
            </a>

            <div class="d-flex gap-2">

<?php if ($authUser && $authUser->role === 'admin'): ?>
                <?= $this->Form->postLink(
                    '<i class="bi bi-trash"></i> Supprimer',
                    ['action' => 'delete', $client->id],
                    [
                        'class' => 'btn btn-outline-danger',
                        'escape' => false,
                        'confirm' => 'Êtes-vous sûr de vouloir supprimer ce client ?'
                    ]
                ) ?>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>

<style>
/* =========================
   TABLE - LIGHT MODE
========================= */
.crm-form-table th {
    background: #f8fafc;
    font-weight: 600;
    font-size: 13px;
    color: #374151;
    border-color: #e3e6f0;
}

.crm-form-table td {
    background: #fff;
    border-color: #e3e6f0;
}

.crm-form-table tr:hover th,
.crm-form-table tr:hover td {
    background: #f1f5f9;
}

/* =========================
   CARD
========================= */
.card {
    border-radius: 14px;
    overflow: hidden;
}

/* =========================
   DARK MODE
========================= */
body.dark-mode {
    background: #1a1a2e;
    color: #f8fafc;
}

body.dark-mode .card {
    background: #212529;
    border-color: #343a40;
}

body.dark-mode .card-footer {
    background: #2d3748;
    border-color: #495057;
}

body.dark-mode .crm-form-table th {
    background: #2d3748;
    color: #f8fafc;
    border-color: #495057;
}

body.dark-mode .crm-form-table td {
    background: #212529;
    color: #e5e7eb;
    border-color: #495057;
}

body.dark-mode .crm-form-table tr:hover th,
body.dark-mode .crm-form-table tr:hover td {
    background: #343a40;
}

body.dark-mode .btn-light {
    background: #374151;
    color: #f8fafc;
    border-color: #4b5563;
}

body.dark-mode a.text-decoration-none {
    color: #60a5fa;
}
</style>