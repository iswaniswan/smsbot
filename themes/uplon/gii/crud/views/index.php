<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
use fedemotta\datatables\DataTables;
\app\assets\DataTableAsset::register($this);
<?php endif ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = <?= $generator->generateString("Daftar ".Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">

    <div style="margin-bottom:20px; text-align:right">
        <?= "<?= " ?>Html::a('<i class="fa fa-plus"></i> Add <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>', ['create'], ['class' => 'btn btn-sm btn-primary btn-flat']) ?>
        <?= "<?= " ?>Html::a('<i class="fa fa-file-excel"></i> Export <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>', Yii::$app->request->url.'&export=1', ['class' => 'btn btn-sm btn-primary btn-flat']) ?>
    </div>

    <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index card card-default shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= "<?= "; ?> $this->title; <?= "?>"; ?>
        </h6>
    </div>

    <div class="card-body">
        <?php if(!empty($generator->searchModelClass)): ?>
            <?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php endif; ?>
    <?= $generator->enablePjax ? '<?php Pjax::begin(); ?>' : '' ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= "?>DataTables::widget([
            'dataProvider' => $dataProvider,
            <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n'columns' => [\n" : "'columns' => [\n"; ?>
                [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'No',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
                ],
            <?php
            $count = 0;
            if (($tableSchema = $generator->getTableSchema()) === false) {
                foreach ($generator->getColumnNames() as $name) { ?>
                    [
                    'attribute' => <?= $name; ?>,
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'text-align:center;'],
                    ],
                <?php } ?>
            <?php } else {
                foreach ($tableSchema->columns as $column) {
                    $format = $generator->generateColumnFormat($column); ?>
                    [
                    'attribute' => '<?= $column->name; ?>',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'text-align:center;'],
                    'contentOptions' => ['style' => 'text-align:center;'],
                    ],
                <?php } ?>
            <?php } ?>
                [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align:center;width:80px']
                ],
            ],
        ]);?>
    <?php else: ?>
        <?= "<?= " ?>ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                },
            ]) ?>
    <?php endif; ?>
<?= $generator->enablePjax ? '<?php Pjax::end(); ?>' : '' ?>
    </div>
    </div>
</div>