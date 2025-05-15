<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h2>Profil Pengguna</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Username:</strong> <?= esc($username) ?></li>
        <li class="list-group-item"><strong>Role:</strong> <?= esc($role) ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?= esc($email) ?></li>
        <li class="list-group-item"><strong>Waktu Login:</strong> <?= esc($login_time) ?></li>
        <li class="list-group-item"><strong>Status Login:</strong> <?= esc($isLoggedin ? 'Login' : 'Logout') ?></li>
    </ul>
</div>

<?= $this->endSection() ?>
