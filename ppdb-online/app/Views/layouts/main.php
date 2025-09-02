<?= $this->include('partials/header') ?>

<?= $this->include('partials/nav') ?>

<!-- Main Content -->
<main class="container mx-auto px-4 py-8">
    <?= $this->renderSection('content') ?>
</main>

<?= $this->include('partials/footer') ?>

</body>
</html>