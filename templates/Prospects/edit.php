<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold">Prospect</h2>
        <p class="text-muted mb-0">Formulaire de gestion du prospect</p>
    </div>

    <!-- TABLE FORM CARD -->
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <?= $this->Form->create($prospect) ?>

            <table class="table table-bordered align-middle mb-0 crm-form-table">

                <tbody>

                    <tr>
                        <th width="25%">Company Name</th>
                        <td>
                            <?= $this->Form->control('company_name', [
                                'label' => false,
                                'class' => 'form-control'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Contact Name</th>
                        <td>
                            <?= $this->Form->control('contact_name', [
                                'label' => false,
                                'class' => 'form-control'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>
                            <?= $this->Form->control('email', [
                                'label' => false,
                                'class' => 'form-control'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>
                            <?= $this->Form->control('phone', [
                                'label' => false,
                                'class' => 'form-control'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>City</th>
                        <td>
                            <?= $this->Form->control('city', [
                                'label' => false,
                                'class' => 'form-control'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <?= $this->Form->control('status', [
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Notes</th>
                        <td>
                            <?= $this->Form->control('notes', [
                                'label' => false,
                                'class' => 'form-control',
                                'rows' => 4,
                                'type' => 'textarea'
                            ]) ?>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!-- FOOTER ACTIONS -->
        <div class="card-footer d-flex justify-content-between">

            <a href="<?= $this->Url->build(['action' => 'index']) ?>"
               class="btn btn-light">
                Cancel
            </a>

            <?= $this->Form->button('Save Prospect', [
                'class' => 'btn btn-primary'
            ]) ?>

        </div>

        <?= $this->Form->end() ?>

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
    vertical-align: middle;
    border-color: #e3e6f0;
}

.crm-form-table td {
    background: #ffffff;
    border-color: #e3e6f0;
}

.crm-form-table tr:hover th,
.crm-form-table tr:hover td {
    background: #f1f5f9;
}

.crm-form-table .form-control,
.crm-form-table .form-select {
    border-radius: 8px;
    padding: 8px 10px;
    border: 1px solid #e5e7eb;
}

.crm-form-table .form-control:focus,
.crm-form-table .form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.15rem rgba(37,99,235,0.15);
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

body.dark-mode .crm-form-table .form-control,
body.dark-mode .crm-form-table .form-select {
    background:  #2d3748;
    color: #f8fafc;
    border-color: #495057;
}

body.dark-mode .crm-form-table .form-control:focus,
body.dark-mode .crm-form-table .form-select:focus {
    border-color: #60a5fa;
    box-shadow: 0 0 0 0.15rem rgba(96,165,250,0.15);
}

body.dark-mode .btn-light {
    background: #374151;
    color: #f8fafc;
    border-color: #4b5563;
}
</style>