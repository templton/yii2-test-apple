<?php

/**
 * @var $colors array
 * @var $apples array
 */

?> <style> <?php
if (isset($colors) && is_array($colors)){
    foreach ($colors as $color) {
        echo '
            .apple-'.$color.' {
                background: '.$color.';
            }
            
            .apple-'.$color.':before {
                background: '.$color.';
            }
        ';
    }
}
?> </style> <?php

?>

<div class="row">
    <?php
    foreach ($apples as $apple) {
        ?>
            <div class="col-sm-3">
                <div class="apple-container">
                    <div class="apple-figure apple-<?= $apple['color'] ?>"></div>
                </div>
                <div class="apple-info">
                    <div>Статус: <?= $apple['statusName'] ?></div>
                    <div>Дата падения: <?= $apple['fallenDate'] ?></div>
                </div>
            </div>
        <?php
    }
    ?>
</div>