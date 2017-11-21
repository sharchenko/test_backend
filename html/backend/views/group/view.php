<?php

use backend\assets\AppAsset;
use backend\models\Group;
use yii\web\View;

/** @var $this View */
/** @var $group Group */

$this->registerJsFile('/js/group-order.js', ['position' => $this::POS_END, 'depends' => AppAsset::className()]);

?>
<span id="group-id" hidden><?= $group->id ?></span>
<div class="panel">
    <div class="panel-body">
        <div id="group-order-root">

        </div>
    </div>
</div>
