<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { background-color: #f8f9fa; }
    .register-container { margin-top: 3rem; margin-bottom: 3rem; }
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
    }
    .card-title { font-weight: 700; color: #333; }
    .btn-register {
        font-size: 0.9rem;
        letter-spacing: 0.05rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }
    .input-group-text {
        background-color: transparent;
        border-right: none;
    }
    .form-control { border-left: none; }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    .top-nav, footer { display: none !important; }
    main.main { padding: 0 !important; }

    /* Dark Mode */
    body.dark-mode { background-color: #121212; color: #ffffff; }
    body.dark-mode .card { background-color: #1e1e1e; color: white; }
    body.dark-mode .card-title,
    body.dark-mode label { color: white; }
    body.dark-mode .text-muted { color: #b0b0b0 !important; }
    body.dark-mode .form-control {
        background-color: #2d2d2d;
        color: white;
        border-color: #444;
    }
    body.dark-mode .form-select {
        background-color: #2d2d2d;
        color: white;
        border-color: #444;
    }
    body.dark-mode .form-control::placeholder { color: #aaa; }
    body.dark-mode .input-group-text {
        background-color: #2d2d2d;
        color: white;
        border-color: #444;
    }
    body.dark-mode a { color: #4da3ff; }
    body.dark-mode .btn-outline-secondary {
        color: #aaa;
        border-color: #555;
    }
    body.dark-mode .btn-outline-secondary:hover {
        background-color: #333;
        color: #fff;
    }

    /* Password & field checks */
    #password-checks { margin-top: 0.5rem; }
    #password-checks li { font-size: 0.85rem; transition: color 0.2s; }
    .field-check { font-size: 0.85rem; transition: color 0.2s; margin-top: 0.3rem; display: none; }
    .field-check.visible { display: block; }
</style>

<div class="container register-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4 p-sm-5">

                    <div class="text-end mb-3">
                        <button id="theme-toggle" class="btn btn-outline-secondary">
                            <i id="theme-icon" class="bi bi-moon-fill"></i>
                        </button>
                    </div>

                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill display-1 text-success"></i>
                        <h3 class="card-title mt-3">Create Account</h3>
                        <p class="text-muted">Fill in the details to register</p>
                    </div>

                    <?= $this->Flash->render() ?>

                    <?= $this->Form->create($user, ['class' => 'row g-3', 'id' => 'register-form']) ?>

                    <!-- First Name -->
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <?= $this->Form->control('firstname', [
                            'label'       => false,
                            'class'       => 'form-control',
                            'placeholder' => 'John',
                            'id'          => 'firstname'
                        ]) ?>
                        <div id="firstname-check" class="field-check text-danger">
                            ❌ Lettres et espaces uniquement (ex: Jean-Pierre)
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <?= $this->Form->control('lastname', [
                            'label'       => false,
                            'class'       => 'form-control',
                            'placeholder' => 'Doe',
                            'id'          => 'lastname'
                        ]) ?>
                        <div id="lastname-check" class="field-check text-danger">
                            ❌ Lettres et espaces uniquement (ex: Ben Ali)
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <?= $this->Form->control('email', [
                                'label'       => false,
                                'class'       => 'form-control',
                                'placeholder' => 'john.doe@example.com',
                                'id'          => 'email',
                                'templates'   => ['inputContainer' => '{{content}}']
                            ]) ?>
                        </div>
                        <div id="email-check" class="field-check text-danger">
                            ❌ Format invalide (ex: john@example.com)
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <?= $this->Form->control('password', [
                                'label'       => false,
                                'class'       => 'form-control',
                                'placeholder' => '••••••••',
                                'id'          => 'password',
                                'templates'   => ['inputContainer' => '{{content}}']
                            ]) ?>
                        </div>
                        <ul id="password-checks" class="list-unstyled mt-2">
                            <li id="length-check" class="text-danger">❌ Au moins 8 caractères</li>
                            <li id="letter-check" class="text-danger">❌ Contient une lettre</li>
                            <li id="number-check" class="text-danger">❌ Contient un chiffre</li>
                        </ul>
                    </div>

                    <!-- Role -->
                    <div class="col-12">
                        <label class="form-label">Role</label>
                        <?= $this->Form->control('role', [
                            'label'   => false,
                            'class'   => 'form-select',
                            'options' => ['admin' => 'Admin', 'user' => 'User'],
                            'type'    => 'select'
                        ]) ?>
                    </div>

                    <div class="col-12 d-grid mt-4">
                        <?= $this->Form->button(__('Register'), [
                            'class' => 'btn btn-success btn-register text-uppercase fw-bold'
                        ]) ?>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0 text-muted small">Already have an account?</p>
                        <?= $this->Html->link("Log In Here", ['action' => 'login'], [
                            'class' => 'text-decoration-none fw-bold'
                        ]) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── Dark Mode ──────────────────────────────────────────────
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon   = document.getElementById('theme-icon');

    function applyTheme(isDark) {
        if (isDark) {
            document.body.classList.add('dark-mode');
            themeIcon.className = 'bi bi-sun-fill';
        } else {
            document.body.classList.remove('dark-mode');
            themeIcon.className = 'bi bi-moon-fill';
        }
    }

    applyTheme(localStorage.getItem('theme') === 'dark');

    themeToggle.addEventListener('click', () => {
        const isDark = !document.body.classList.contains('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        applyTheme(isDark);
    });

    // ── Regex ──────────────────────────────────────────────────
    const nameRegex  = /^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    // ── Name Validation ────────────────────────────────────────
    function validateName(inputId, checkId, exampleText) {
        const input = document.getElementById(inputId);
        const check = document.getElementById(checkId);

        input.addEventListener('input', function () {
            const val = this.value.trim();

            if (val === '') {
                check.classList.remove('visible', 'text-success', 'text-danger');
                input.classList.remove('is-valid', 'is-invalid');
                return;
            }

            if (nameRegex.test(val)) {
                check.className     = 'field-check text-success visible';
                check.textContent   = '✔ Nom valide';
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                check.className     = 'field-check text-danger visible';
                check.textContent   = '❌ ' + exampleText;
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        });
    }

    validateName('firstname', 'firstname-check', 'Lettres et espaces uniquement (ex: Jean-Pierre)');
    validateName('lastname',  'lastname-check',  'Lettres et espaces uniquement (ex: Ben Ali)');

    // ── Email Validation ───────────────────────────────────────
    const emailInput = document.getElementById('email');
    const emailCheck = document.getElementById('email-check');

    emailInput.addEventListener('input', function () {
        const val = this.value.trim();

        if (val === '') {
            emailCheck.classList.remove('visible', 'text-success', 'text-danger');
            emailInput.classList.remove('is-valid', 'is-invalid');
            return;
        }

        if (emailRegex.test(val)) {
            emailCheck.className   = 'field-check text-success visible';
            emailCheck.textContent = '✔ Email valide';
            emailInput.classList.remove('is-invalid');
            emailInput.classList.add('is-valid');
        } else {
            emailCheck.className   = 'field-check text-danger visible';
            emailCheck.textContent = '❌ Format invalide (ex: john@example.com)';
            emailInput.classList.remove('is-valid');
            emailInput.classList.add('is-invalid');
        }
    });

    // ── Password Checks ────────────────────────────────────────
    const passwordInput = document.getElementById('password');
    const lengthCheck   = document.getElementById('length-check');
    const letterCheck   = document.getElementById('letter-check');
    const numberCheck   = document.getElementById('number-check');

    passwordInput.addEventListener('input', function () {
        const val = this.value;

        if (val.length >= 8) {
            lengthCheck.className   = 'text-success';
            lengthCheck.textContent = '✔ Au moins 8 caractères';
        } else {
            lengthCheck.className   = 'text-danger';
            lengthCheck.textContent = '❌ Au moins 8 caractères';
        }

        if (/[A-Za-z]/.test(val)) {
            letterCheck.className   = 'text-success';
            letterCheck.textContent = '✔ Contient une lettre';
        } else {
            letterCheck.className   = 'text-danger';
            letterCheck.textContent = '❌ Contient une lettre';
        }

        if (/\d/.test(val)) {
            numberCheck.className   = 'text-success';
            numberCheck.textContent = '✔ Contient un chiffre';
        } else {
            numberCheck.className   = 'text-danger';
            numberCheck.textContent = '❌ Contient un chiffre';
        }
    });

    // ── Bloquer submit si champs invalides ─────────────────────
    document.getElementById('register-form').addEventListener('submit', function (e) {
        let valid = true;

        const firstname = document.getElementById('firstname').value.trim();
        const lastname  = document.getElementById('lastname').value.trim();
        const email     = document.getElementById('email').value.trim();
        const password  = document.getElementById('password').value;

        // Vérif prénom
        if (!nameRegex.test(firstname) || firstname === '') {
            const check = document.getElementById('firstname-check');
            check.className   = 'field-check text-danger visible';
            check.textContent = '❌ Lettres et espaces uniquement (ex: Jean-Pierre)';
            document.getElementById('firstname').classList.add('is-invalid');
            valid = false;
        }

        // Vérif nom
        if (!nameRegex.test(lastname) || lastname === '') {
            const check = document.getElementById('lastname-check');
            check.className   = 'field-check text-danger visible';
            check.textContent = '❌ Lettres et espaces uniquement (ex: Ben Ali)';
            document.getElementById('lastname').classList.add('is-invalid');
            valid = false;
        }

        // Vérif email
        if (!emailRegex.test(email) || email === '') {
            const check = document.getElementById('email-check');
            check.className   = 'field-check text-danger visible';
            check.textContent = '❌ Format invalide (ex: john@example.com)';
            document.getElementById('email').classList.add('is-invalid');
            valid = false;
        }

        // Vérif password
        if (password.length < 8 || !/[A-Za-z]/.test(password) || !/\d/.test(password)) {
            document.getElementById('password').classList.add('is-invalid');
            valid = false;
        }

        if (!valid) e.preventDefault();
    });
</script>