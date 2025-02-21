<?php

/* @var $this yii\web\View */
/* @var $model app\models\UserRole */
/* @var $referrer string */

$this->title = 'Edit User Role';
$this->params['breadcrumbs'][] = ['label' => 'User Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Sunting';
?>
<div class="user-role-update">

    <?= $this->render('_form', [
        'model' => $model,
        'referrer'=> $referrer
    ]) ?>

</div>
