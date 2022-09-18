<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
\app\assets\DataTableAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Daftar Member';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \app\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => [
            'title' => 'Member'
    ],
]) ?>

<div class="row mb-5">
    <div class="container-fluid">
        <div style="margin-bottom: 1rem; text-align:left">
            <?= Html::a('<span class="mr-2"><i class="ti-plus"></i></span>Add', ['create'], ['class' => 'btn btn-primary mb-1']) ?>
            <?= Html::a('<span class="mr-2"><i class="ti-printer"></i></span>Print', ['#'], [
                    'class' => 'btn btn-info mb-1',
                    'onclick' => 'dtPrint()'
            ]) ?>
            <div class="btn-group mr-1">
                <?= Html::a('<span class="mr-2"><i class="ti-download"></i></span>Export', ['#'], [
                        'class' => 'btn btn-success mb-1 dropdown-toggle waves-effect waves-light',
                        'data-toggle' => 'dropdown'
                ]) ?>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                    <?= Html::a('Excel', ['#'], [
                            'class' => 'dropdown-item',
                            'onclick' => 'dtExportExcel()'
                    ]) ?>
                    <?= Html::a('Pdf', ['#'], [
                            'class' => 'dropdown-item',
                            'onclick' => 'dtExportPdf()'
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="member-index card-box shadow mb-4">
            <div class="mb-4">
                <h4 class="header-title" style="">
                    <?=  $this->title; ?>
                </h4>
            </div>

            <?= \app\widgets\DataTables::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'clientOptions' => [
                        'dom' => 'lfrtipB',
                        'buttons' => ['copy', 'csv', 'excel', 'pdf', 'print']
                ],
                'columns' => [
                    [
                        'attribute' => 'id_user',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:left;'],
                        'contentOptions' => ['style' => 'text-align:left;'],
                    ],
                    [
                        'attribute' => 'id_paket',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:left;'],
                        'contentOptions' => ['style' => 'text-align:left;'],
                    ],
                    [
                        'attribute' => 'nama',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:left;'],
                        'contentOptions' => ['style' => 'text-align:left;'],
                    ],
                    [
                        'attribute' => 'no_ktp',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:left;'],
                        'contentOptions' => ['style' => 'text-align:left;'],
                    ],
                    [
                        'attribute' => 'phone',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align:left;'],
                        'contentOptions' => ['style' => 'text-align:left;'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'visibleButtons' => ['view' => true, 'update' => true, 'delete' => true],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a(
                                    '<i class="ti-eye"></i>',
                                    ['view', 'id' => @$model->id],
                                    [
                                        'title' => 'Detail',
                                        'data-pjax' => '0',
                                    ]
                                );
                            },
                            'update' => function ($url, $model) {
                                return Html::a(
                                    '<i class="ti-pencil"></i>',
                                    ['update', 'id' => @$model->id],
                                    [
                                        'title' => 'Detail',
                                        'data-pjax' => '0',
                                    ]
                                );
                            },
                            'delete' => function ($url, $model) {
                                return Html::a(
                                    '<i class="ti-trash"></i>',
                                    ['delete', 'id' => @$model->id],
                                    [
                                        'title' => 'Delete',
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method'  => 'post',
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]);?>
    </div>
</div>

<?php

$script = <<<JS
    const dtPrint = () => {
        const dtBtn = $('.btn.buttons-print');
        dtBtn.trigger('click');
    }
    const dtExportPdf = () => {
        const dtBtn = $('.btn.buttons-pdf.buttons-html5');
        dtBtn.trigger('click');
    }
    const dtExportExcel = (e) => {
        const dtBtn = $('.btn.buttons-excel.buttons-html5');
        dtBtn.trigger('click');
    }
JS;

$this->registerJs($script, \yii\web\View::POS_END);

?>