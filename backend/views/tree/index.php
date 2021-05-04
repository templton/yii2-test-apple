<?php

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var $colors array
 * @var $apples array
 * @var $appleId ?int
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
    <div class="col-sm-12">
        <?= Html::beginForm(['tree/create-new-tree'], 'post') ?>
        <?= Html::submitButton('Пересоздать набор яблок') ?>
        <?= Html::endForm() ?>
    </div>
</div>

<div class="row">
    <?php
    foreach ($apples as $apple) {
        ?>
            <div class="col-sm-3 <?= $apple['id'] == $appleId ? ' active-apple ' : '' ?>">
                <div class="apple-container">
                    <div class="apple-figure apple-<?= $apple['color'] ?>"></div>
                </div>
                <div class="apple-info">
                    <div>Статус: <?= $apple['statusName'] ?></div>
                    <div>Осталось: <?= $apple['currentVolume'] ?></div>
                    <div>Дата падения: <?= $apple['fallenDate'] ?></div>

                    <?php if ($apple['can_fall']) { ?>
                        <div class="action-block">
                            <div class="action-header">Бросить яблоко на землю</div>
                            <?= Html::beginForm(['tree/apple-fall'], 'post') ?>
                            <?= Html::input('hidden', 'appleId', $apple['id']) ?>
                            <?= Html::submitButton('Бросить') ?>
                            <?= Html::endForm() ?>
                        </div>
                    <?php }?>

                    <?php if ($apple['can_eat']) { ?>
                        <div class="action-block">
                            <div class="action-header">Откусить от яблока %</div>
                            <?= Html::beginForm(['tree/apple-eat'], 'post') ?>
                            <?= Html::input('text', 'volume', '30') ?>
                            <?= Html::input('hidden', 'appleId', $apple['id']) ?>
                            <?= Html::submitButton('Откусить') ?>
                            <?= Html::endForm() ?>
                        </div>
                    <?php }?>

                    <?php if ($apple['errors']) { ?>
                            <div class="alert-danger"><?= $apple['errors'] ?></div>
                    <?php }?>

                </div>
            </div>
        <?php
    }
    ?>
</div>