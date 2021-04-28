<?php

/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

$schedule->exec('php yii apple/mark-rotten-apples')->cron('* * * * *');