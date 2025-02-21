<?php

use app\components\Mode;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserRole */
/* @var $mode \app\components\Mode */
/* @var $referrer string */

$this->title = "Detail User Role";
if ($mode !== Mode::READ) {
    $this->title = ucwords($mode) . " User Role";
}
$this->params['breadcrumbs'][] = ['label' => 'User Role', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \app\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => [
        'title' => " User Role"
    ],
]) ?>

<?= $this->render('_form', [
    'model' => $model,
    'referrer'=> @$referrer,
    'mode' => $mode
]) ?>