<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Call $call
 */
?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-telephone-fill" style="color:#16a34a;"></i> Appel
        </h2>
        <p class="text-muted mb-0">Détails de l'appel</p>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <table class="table table-bordered align-middle mb-0 crm-form-table">

                <tbody>

                    <tr>
                        <th width="25%">ID Appel</th>
                        <td>
                            <span class="text-muted">
                                #<?= h($call->id) ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Prospect</th>
                        <td>
                            <?php if (!empty($call->prospect)) : ?>
                                <?= $this->Html->link(
                                    '<i class="bi bi-person-bounding-box"></i> ' . h($call->prospect->company_name),
                                    [
                                        'controller' => 'Prospects',
                                        'action' => 'view',
                                        $call->prospect->id
                                    ],
                                    [
                                        'class' => 'btn btn-sm btn-outline-primary',
                                        'escape' => false
                                    ]
                                ) ?>
                            <?php else : ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Sujet</th>
                        <td><?= h($call->subject) ?></td>
                    </tr>

                    <tr>
                        <th>Date de l'appel</th>
                        <td>
                            <?= $call->call_date
                                ? $call->call_date->format('d/m/Y H:i')
                                : '—' ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Prochain appel</th>
                        <td>
                            <?= $call->next_call_date
                                ? $call->next_call_date->format('d/m/Y H:i')
                                : '—' ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Commentaire</th>
                        <td>
                            <?= !empty($call->comment)
                                ? nl2br(h($call->comment))
                                : '<span class="text-muted">Aucun commentaire</span>' ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Date de création</th>
                        <td>
                            <?= $call->created
                                ? $call->created->format('d/m/Y H:i')
                                : '—' ?>
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
                <?= $this->Html->link(
                    '<i class="bi bi-pencil-square"></i> Modifier',
                    ['action' => 'edit', $call->id],
                    [
                        'class' => 'btn btn-outline-warning',
                        'escape' => false
                    ]
                ) ?>

                <?= $this->Form->postLink(
                    '<i class="bi bi-trash"></i> Supprimer',
                    ['action' => 'delete', $call->id],
                    [
                        'class' => 'btn btn-outline-danger',
                        'escape' => false,
                        'confirm' => 'Êtes-vous sûr de vouloir supprimer cet appel ?'
                    ]
                ) ?>
<?php endif; ?>
            </div>

        </div>

    </div>

</div>

<style>

.crm-form-table th {
    background: #f8fafc;
    font-weight: 600;
    font-size: 13px;
    color: #374151;
}

.crm-form-table td {
    background: #fff;
}

.crm-form-table tbody tr:hover {
    background-color: #f1f5f9;
}

.card {
    border-radius: 14px;
    overflow: hidden;
}

/* ===== DARK MODE ===== */

body.dark-mode .mb-4 h2,
body.dark-mode .mb-4 p {
    color: #ffffff;
}

body.dark-mode .crm-form-table th {
    background: #1a1a1a;
    color: #e5e7eb;
    border-color: #374151;
}

body.dark-mode .crm-form-table td {
    background: #1a1a1a;
    color: #e5e7eb;
    border-color: #374151;
}

body.dark-mode .crm-form-table tbody tr:hover {
    background-color: #2b3444;
}

body.dark-mode .card {
    border-color: #374151;
}

body.dark-mode .card-footer {
    background: #1a1a1a;
    border-top: 1px solid #374151;
}

body.dark-mode .btn-light {
    background: #374151;
    color: #fff;
    border-color: #4b5563;
}

</style>