<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Call $call
 * @var \Cake\Collection\CollectionInterface|string[] $prospects
 */
?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-telephone-plus-fill" style="color:#16a34a;"></i>
            Nouvel Appel
        </h2>
        <p class="text-muted mb-0">
            Ajouter un nouvel appel pour un prospect
        </p>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <?= $this->Form->create($call) ?>

            <table class="table table-bordered align-middle mb-0 crm-form-table">

                <tbody>

                    <tr>
                        <th width="25%">Prospect</th>
                        <td>
                            <?= $this->Form->control('prospect_id', [
                                'options' => $prospects,
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Date de l'appel</th>
                        <td>
                            <?= $this->Form->control('call_date', [
                                'label' => false,
                                'class' => 'form-control'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Sujet</th>
                        <td>
                            <?= $this->Form->control('subject', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Sujet de l’appel'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Commentaire</th>
                        <td>
                            <?= $this->Form->control('comment', [
                                'type' => 'textarea',
                                'rows' => 4,
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Ajouter un commentaire...'
                            ]) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Prochain appel</th>
                        <td>
                            <?= $this->Form->control('next_call_date', [
                                'empty' => true,
                                'label' => false,
                                'class' => 'form-control'
                            ]) ?>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!-- ACTIONS -->
        <div class="card-footer d-flex justify-content-between">

            <?= $this->Html->link(
                '<i class="bi bi-arrow-left"></i> Retour',
                ['action' => 'index'],
                [
                    'class' => 'btn btn-light',
                    'escape' => false
                ]
            ) ?>

            <?= $this->Form->button(
                '<i class="bi bi-check-circle"></i> Enregistrer',
                [
                    'class' => 'btn btn-success',
                    'escapeTitle' => false
                ]
            ) ?>

        </div>

        <?= $this->Form->end() ?>

    </div>

</div>

<style>

.crm-form-table th{
    background:#f8fafc;
    font-weight:600;
    font-size:13px;
    color:#374151;
    vertical-align:middle;
}

.crm-form-table td{
    background:#fff;
}

.crm-form-table tbody tr:hover{
    background-color:#f1f5f9;
}

.card{
    border-radius:14px;
    overflow:hidden;
}

.form-control,
.form-select{
    border-radius:8px;
}

/* DARK MODE */

body.dark-mode .mb-4 h2,
body.dark-mode .mb-4 p{
    color:#ffffff;
}

body.dark-mode .crm-form-table th{
    background:#1a1a1a;
    color:#e5e7eb;
    border-color:#374151;
}

body.dark-mode .crm-form-table td{
    background:#1a1a1a;
    color:#e5e7eb;
    border-color:#374151;
}

body.dark-mode .form-control,
body.dark-mode .form-select{
    background:#2d3748;
    color:#fff;
    border-color:#374151;
}

body.dark-mode .card-footer{
    background:#1a1a1a;
    border-top:1px solid #374151;
}

</style>