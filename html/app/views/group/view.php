<?php

use app\assets\AppAsset;
use app\models\Group;
use yii\web\View;

/** @var $this View */
/** @var $group Group */

$this->registerJsFile('/js/group-order.js', ['position' => $this::POS_END, 'depends' => AppAsset::className()]);

?>

<div class="panel">
    <div class="panel-body">
        <div id="group-order-root">

        </div>
    </div>
</div>
