<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = "Detail <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)); ?>";
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view card card-primary">

    <div class="card-header">
        <h3 class="card-title">Detail <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)); ?></h3>
    </div>

    <div class="card-body">

        <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="180px" style="text-align:left">{label}</th><td>{value}</td></tr>',
        'attributes' => [
        <?php
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) { ?>
                [
                'attribute' => '<?= $name; ?>',
                'format' => 'raw',
                'value' => $model-><?= $name; ?>,
                ],
            <?php }
        } else {
            foreach ($generator->getTableSchema()->columns as $column) { ?>
                [
                'attribute' => '<?= $column->name; ?>',
                'format' => 'raw',
                'value' => $model-><?= $column->name; ?>,
                ],
            <?php }
        }
        ?>
        ],
        ]) ?>

    </div>

    <div class="card-footer">
        <?= "<?= " ?>Html::a('<i class="fa fa-pencil-alt"></i> Edit <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)); ?>', ['update', <?= $urlParams ?>], ['class' => 'btn btn-success btn-flat']) ?>
        <?= "<?= " ?>Html::a('<i class="fa fa-list"></i> Daftar <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)); ?>', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
    </div>

</div>
