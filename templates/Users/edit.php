<style>
body{
    background:#f5f7fb;
}

.edit-container{
    max-width:750px;
    margin:auto;
}

.edit-title{
    font-size:28px;
    font-weight:700;
    color:#1f2937;
    margin-bottom:20px;
}

.edit-card{
    border:none;
    border-radius:16px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.edit-header{
    background:linear-gradient(135deg,#2563eb,#1e40af);
    color:#fff;
    padding:25px;
    text-align:center;
}

.edit-header i{
    font-size:45px;
    margin-bottom:10px;
}

.edit-header h3{
    margin:0;
    font-weight:600;
}

.edit-body{
    padding:30px;
}

.edit-body .form-control{
    border-radius:10px;
    padding:10px 14px;
}

.edit-body label{
    font-weight:600;
    color:#374151;
    margin-bottom:6px;
}

.btn-save{
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:10px;
    padding:10px 25px;
}

.btn-save:hover{
    background:#1d4ed8;
    color:#fff;
}

.btn-cancel{
    border-radius:10px;
    padding:10px 25px;
}

/* ================= DARK MODE ================= */

body.dark-mode{
    background:#1a1a1a;
}

body.dark-mode .edit-title{
    color:#fff;
}

body.dark-mode .edit-card{
    background:#212529;
    border:1px solid #343a40;
}

body.dark-mode .edit-header{
    background:linear-gradient(135deg,#1e293b,#0f172a);
}

body.dark-mode .edit-body{
    background:#212529;
}

body.dark-mode label{
    color:#fff;
}

body.dark-mode .form-control{
    background:#1a1a1a;
    color:#fff;
    border:1px solid #495057;
}

body.dark-mode .form-control:focus{
    background:#1a1a1a;
    color:#fff;
    border-color:#3b82f6;
    box-shadow:none;
}

body.dark-mode .btn-save{
    background:#3b82f6;
}

body.dark-mode .btn-save:hover{
    background:#2563eb;
}

body.dark-mode .btn-cancel{
    background:#343a40;
    color:#fff;
    border:1px solid #495057;
}

body.dark-mode .btn-cancel:hover{
    background:#495057;
}
#password-checks{
    margin-top:10px;
}

#password-checks li{
    font-size:14px;
    transition:.2s;
}
</style>

<div class="container mt-4 edit-container">

    <h2 class="edit-title">
        <i class="bi bi-pencil-square"></i> Modifier le Profil
    </h2>

    <div class="card edit-card">

        <div class="edit-header">
            <i class="bi bi-person-gear"></i>
            <h3>Modifier les informations</h3>
        </div>

        <div class="edit-body">

            <?= $this->Form->create($user) ?>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <?= $this->Form->control('firstname',[
                        'label'=>'Prénom',
                        'class'=>'form-control'
                    ]) ?>
                </div>

                <div class="col-md-6 mb-3">
                    <?= $this->Form->control('lastname',[
                        'label'=>'Nom',
                        'class'=>'form-control'
                    ]) ?>
                </div>

                <div class="col-md-12 mb-3">
    <?= $this->Form->control('email', [
        'label' => 'Email',
        'class' => 'form-control',
        'disabled' => true
    ]) ?>
</div>

                <div class="col-md-12 mb-3">
    <?= $this->Form->control('password', [
        'label' => 'Nouveau mot de passe',
        'required' => false,
        'value' => '',
        'id' => 'password',
        'class' => 'form-control',
        'placeholder' => 'Laisser vide pour conserver le mot de passe'
    ]) ?>

    <ul id="password-checks" class="list-unstyled mt-2">
        <li id="length-check" class="text-danger">❌ Au moins 8 caractères</li>
        <li id="letter-check" class="text-danger">❌ Contient une lettre</li>
        <li id="number-check" class="text-danger">❌ Contient un chiffre</li>
    </ul>
</div>
<div class="col-12">
    <label class="form-label">Role</label>

    <?= $this->Form->control('role', [
        'type' => 'text',
        'label' => false,
        'class' => 'form-control',
        'disabled' => true
    ]) ?>
</div>
            <div class="text-end">

                <?= $this->Html->link(
                    '<i class="bi bi-arrow-left"></i> Annuler',
                    ['action'=>'profile'],
                    [
                        'class'=>'btn btn-secondary btn-cancel me-2',
                        'escape'=>false
                    ]
                ) ?>

                <?= $this->Form->button(
                    '<i class="bi bi-check-circle"></i> Enregistrer',
                    [
                        'class'=>'btn btn-save',
                        'escapeTitle'=>false
                    ]
                ) ?>

            </div>

            <?= $this->Form->end() ?>

        </div>

    </div>

</div>
<script>
    const passwordInput = document.getElementById('password');

if(passwordInput){

    const lengthCheck = document.getElementById('length-check');
    const letterCheck = document.getElementById('letter-check');
    const numberCheck = document.getElementById('number-check');

    passwordInput.addEventListener('input', function(){

        const val = this.value;

        // Au moins 8 caractères
        if(val.length >= 8){
            lengthCheck.className = 'text-success'; //couleur vert
            lengthCheck.innerHTML = '✔ Au moins 8 caractères';
        }else{
            lengthCheck.className = 'text-danger'; //couleur rouge
            lengthCheck.innerHTML = '❌ Au moins 8 caractères';
        }

        // Une lettre
        if(/[A-Za-z]/.test(val)){
            letterCheck.className = 'text-success';
            letterCheck.innerHTML = '✔ Contient une lettre';
        }else{
            letterCheck.className = 'text-danger';
            letterCheck.innerHTML = '❌ Contient une lettre';
        }

        // Un chiffre
        if(/\d/.test(val)){
            numberCheck.className = 'text-success';
            numberCheck.innerHTML = '✔ Contient un chiffre';
        }else{
            numberCheck.className = 'text-danger';
            numberCheck.innerHTML = '❌ Contient un chiffre';
        }

    });

}
</script>