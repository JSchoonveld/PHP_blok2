<?php
require __DIR__ . '/../components/head.html';

?>

<body>
<div class="container pt-4">
    <div class="row mt-4">
        <div class="col"></div>
        <div class="col-6">
            <div class="row">
                <h1>New Category</h1>
            </div>
            <form action="<?= url('/category/create') ?>" method="POST">
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="categoryName" value="<?= $old['name'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="categoryDescription" class="form-label">Description</label>
                    <textarea name="description" id="categoryDescription" class="form-control" cols="30" rows="8"><?= $old['description'] ?? '' ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Store</button>
            </form>
            <a href="./index">Back</a>
        </div>
        <div class="col"></div>
    </div>
</div>

<?php
require __DIR__ . '/../components/footer.html';

?>
