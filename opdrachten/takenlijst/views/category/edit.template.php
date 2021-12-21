<?php
require __DIR__ . '/../components/head.html';
?>

<body>
<div class="container pt-4">
    <div class="row mt-4">
        <div class="col"></div>
        <div class="col-6">
            <h1>Edit</h1>
            <div class="row">
                <h3>
                    <?= $category->name ?>
                </h3>
                <p>
                    <?= $category->description ?>
                </p>
                <a href="<?= url('/category/index') ?>">Back</a>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>

<?php
require __DIR__ . '/../components/footer.html';

?>
