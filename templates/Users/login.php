<?php
/**
 * @var \App\View\AppView $this
 */
?>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #f8f9fa;
    }
    .login-container {
        margin-top: 5rem;
    }
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-weight: 700;
        color: #333;
    }
    .btn-login {
        font-size: 0.9rem;
        letter-spacing: 0.05rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }
    .input-group-text {
        background-color: transparent;
        border-right: none;
    }
    .form-control {
        border-left: none;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    /* Hide Milligram/Cake default styles if they conflict */
    .top-nav, footer { display: none !important; }
    main.main { padding: 0 !important; }
    /* Dark Mode */
body.dark-mode {
    background-color: #121212;
    color: #ffffff;
}

body.dark-mode .card {
    background-color: #1e1e1e;
    color: white;
}

body.dark-mode .card-title,
body.dark-mode label {
    color: white;
}

body.dark-mode .text-muted {
    color: #b0b0b0 !important;
}

body.dark-mode .form-control {
    background-color: #2d2d2d;
    color: white;
    border-color: #444;
}

body.dark-mode .form-control::placeholder {
    color: #aaa;
}

body.dark-mode .input-group-text {
    background-color: #2d2d2d;
    color: white;
    border-color: #444;
}

body.dark-mode a {
    color: #4da3ff;
}
</style>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card overflow-hidden">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-end mb-3">
                    <button id="theme-toggle" class="btn btn-outline-secondary">
                    <i class="bi bi-moon-fill"></i>
                    </button>
                    </div>
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle display-1 text-primary"></i>
                        <h3 class="card-title mt-3">Welcome Back</h3>
                        <p class="text-muted">Please sign in to continue</p>
                    </div>

                    <?= $this->Flash->render() ?>

                    <?= $this->Form->create(null, ['class' => 'needs-validation']) ?>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <?= $this->Form->control('email', [
                                'label' => false,
                                'required' => true,
                                'class' => 'form-control',
                                'placeholder' => 'name@example.com',
                                'templates' => ['inputContainer' => '{{content}}']
                            ]) ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <?= $this->Form->control('password', [
                                'label' => false,
                                'required' => true,
                                'class' => 'form-control',
                                'placeholder' => '••••••••',
                                'templates' => ['inputContainer' => '{{content}}']
                            ]) ?>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <?= $this->Form->button(__('Login'), ['class' => 'btn btn-primary btn-login text-uppercase fw-bold']) ?>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0 text-muted small">Don't have an account?</p>
                        <?= $this->Html->link("Create an Account", ['action' => 'add'], ['class' => 'text-decoration-none fw-bold']) ?>
                    </div>
                    
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const themeToggle = document.getElementById('theme-toggle');

themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');

    if(document.body.classList.contains('dark-mode')){
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
});

// garder le thème après refresh
if(localStorage.getItem('theme') === 'dark'){
    document.body.classList.add('dark-mode');
}
</script>