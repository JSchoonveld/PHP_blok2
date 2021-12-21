<?php
require __DIR__ . '/../components/head.html';

?>
<body>
<div class="container pt-4">
    <div class="row mt-4">
        <div class="col"></div>
        <div class="col-6">
            <div class="row">
                <h1>Categories</h1>
            </div>
            <div class="message">
                <p>
                    <?php if(isset($message))
                        echo $message
                    ?>
                </p>
            </div>
            <div class="row">
                <?php
                if (empty($categories)) { ?>

                    <table class="border">
                        <tr>
                            <th>Category</th>
                        </tr>
                        <tr>
                            <td>
                                No Categories Available
                            </td>
                        </tr>
                    </table>

                <?php
                } else {
                    ?>

                    <table>
                        <tr>
                            <th>Category</th>
                        </tr>
                        <?php foreach($categories as $category) : ?>

                            <tr>
                                <td>
                                    <?= $category->name ?>
                                </td>
                                <td>
                                    <a href="./<?= $category->id ?>"><i class="far fa-edit"></i></a>
                                </td>
                                <td>
                                    <a href="<?= $category->id ?>/delete"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>

                            <?php endforeach; ?>
                    </table>

                <?php
                }
                ?>

            </div>
            <div class="row">
                <a href="./create">Add Category</a>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>

<?php
require __DIR__ . '/../components/footer.html';

?>
