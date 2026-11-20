<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold">Prospect</h2>
        <p class="text-muted mb-0">Détails du prospect</p>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <table class="table table-bordered align-middle mb-0 crm-form-table">

                <tbody>

                    <tr>
                        <th width="25%">Company Name</th>
                        <td><?= h($prospect->company_name) ?></td>
                    </tr>

                    <tr>
                        <th>Contact Name</th>
                        <td><?= h($prospect->contact_name) ?></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><?= h($prospect->email) ?></td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td><?= h($prospect->phone) ?></td>
                    </tr>

                    <tr>
                        <th>City</th>
                        <td><?= h($prospect->city) ?></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-primary">
                                <?= h($statuses[strtolower((string)$prospect->status)] ?? $prospect->status) ?>
                            </span>
                            <?php if (strtolower((string)$prospect->status) === 'client' && !empty($prospect->client)): ?>
                                <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'view', $prospect->client->id]) ?>" class="btn btn-sm btn-outline-success ms-2">
                                    <i class="bi bi-person-check"></i> Voir la fiche client
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Notes</th>
                        <td><?= nl2br(h($prospect->notes)) ?></td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!-- ACTIONS -->
        <div class="card-footer d-flex justify-content-between">

            <a href="<?= $this->Url->build(['action' => 'index']) ?>"
               class="btn btn-light">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            <div class="d-flex gap-2">

<?php if ($authUser && $authUser->role === 'admin'): ?>
                <a href="<?= $this->Url->build(['action' => 'edit', $prospect->id]) ?>"
                   class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
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
    background: #1a1a1a;
    color: #f8fafc;
}

body.dark-mode .card {
    background: #1a1a1a;
    border-color: #343a40;
}

body.dark-mode .card-footer {
    background: #1a1a1a;
    border-color: #495057;
}

body.dark-mode .crm-form-table th {
    background: #1a1a1a;
    color: #f8fafc;
    border-color: #495057;
}

body.dark-mode .crm-form-table td {
    background: #1a1a1a;
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
</style>