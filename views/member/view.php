<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Member */

$this->title = "Detail Member";
$this->params['breadcrumbs'][] = ['label' => 'Member', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \app\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => [],
]) ?>

<div class="row">
    <div class="container-fluid">
        <div class="member-view card-box">
            <div class="card-body">
                <div class="mb-4">
                    <h4 class="header-title" style="">
                        <?=  $this->title; ?>
                    </h4>
                </div>
                <?= DetailView::widget([
                    'model' => $model,
                    'template' => '<tr><th width="180px" style="text-align:left">{label}</th><td>{value}</td></tr>',
                    'attributes' => [
                        [
                            'attribute' => 'id',
                            'format' => 'raw',
                            'value' => $model->id,
                        ],
                        [
                            'attribute' => 'id_user',
                            'format' => 'raw',
                            'value' => $model->id_user,
                        ],
                        [
                            'attribute' => 'id_paket',
                            'format' => 'raw',
                            'value' => $model->id_paket,
                        ],
                        [
                            'attribute' => 'nama',
                            'format' => 'raw',
                            'value' => $model->nama,
                        ],
                        [
                            'attribute' => 'no_ktp',
                            'format' => 'raw',
                            'value' => $model->no_ktp,
                        ],
                        [
                            'attribute' => 'phone',
                            'format' => 'raw',
                            'value' => $model->phone,
                        ],
                        [
                            'attribute' => 'alamat',
                            'format' => 'raw',
                            'value' => $model->alamat,
                        ],
                        [
                            'attribute' => 'id_reff_kotakab',
                            'format' => 'raw',
                            'value' => $model->id_reff_kotakab,
                        ],
                        [
                            'attribute' => 'id_reff_provinsi',
                            'format' => 'raw',
                            'value' => $model->id_reff_provinsi,
                        ],
                        [
                            'attribute' => 'kotakab',
                            'format' => 'raw',
                            'value' => $model->kotakab,
                        ],
                        [
                            'attribute' => 'provinsi',
                            'format' => 'raw',
                            'value' => $model->provinsi,
                        ],
                        [
                            'attribute' => 'kodepos',
                            'format' => 'raw',
                            'value' => $model->kodepos,
                        ],
                        [
                            'attribute' => 'info',
                            'format' => 'raw',
                            'value' => $model->info,
                        ],
                        [
                            'attribute' => 'bank',
                            'format' => 'raw',
                            'value' => $model->bank,
                        ],
                        [
                            'attribute' => 'rekening',
                            'format' => 'raw',
                            'value' => $model->rekening,
                        ],
                        [
                            'attribute' => 'rekening_an',
                            'format' => 'raw',
                            'value' => $model->rekening_an,
                        ],
                        [
                            'attribute' => 'refferal_code',
                            'format' => 'raw',
                            'value' => $model->refferal_code,
                        ],
                        [
                            'attribute' => 'id_member_sponsor',
                            'format' => 'raw',
                            'value' => $model->id_member_sponsor,
                        ],
                        [
                            'attribute' => 'id_member_upline',
                            'format' => 'raw',
                            'value' => $model->id_member_upline,
                        ],
                        [
                            'attribute' => 'photo',
                            'format' => 'raw',
                            'value' => $model->photo,
                        ],
                        [
                            'attribute' => 'is_verified',
                            'format' => 'raw',
                            'value' => $model->is_verified,
                        ],
                        [
                            'attribute' => 'is_active',
                            'format' => 'raw',
                            'value' => $model->is_active,
                        ],
                        [
                            'attribute' => 'date_active',
                            'format' => 'raw',
                            'value' => $model->date_active,
                        ],
                        [
                            'attribute' => 'date_created',
                            'format' => 'raw',
                            'value' => $model->date_created,
                        ],
                        [
                            'attribute' => 'is_deleted',
                            'format' => 'raw',
                            'value' => $model->is_deleted,
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="container-fluid">
        <?= Html::a('<span class="btn-label"><i class="ti-arrow-left"></i></span>Back', ['create'], ['class' => 'btn btn-info mb-1']) ?>
        <?= Html::a('<span class="btn-label"><i class="ti-pencil-alt"></i></span>Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-warning mb-1']) ?>
    </div>
</div>

