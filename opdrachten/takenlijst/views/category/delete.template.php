<?php
require __DIR__ . '/../components/head.html';
?>

<body>
<div class="container pt-4">
    <div class="row mt-4">
        <div class="col"></div>
        <div class="col-6">
            <div class="row">
                <h1>Delete Category</h1>
            </div>
            <div class="row">
                <h3>
                    <?= $category->name ?>
                </h3>
                <p>
                    <?= $category->description ?>
                </p>
            </div>
            <div class="row">
                <h1>
                    Are You Sure?
                </h1>
            </div>
            <div class="row">
                <form action="./delete" method="POST">
                    <a href="<?= url('/category/index') ?>" class="btn btn-danger active" role="button" aria-pressed="true">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>

<?php
require __DIR__ . '/../components/footer.html';

?>
