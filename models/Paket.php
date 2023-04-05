<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paket".
 *
 * @property int $id
 * @property string|null $nama
 * @property int|null $harga
 * @property int|null $reff_bonus_poin
 * @property int|null $keterangan
 * @property int|null $status_aktif
 */
class Paket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['harga', 'reff_bonus_poin', 'keterangan', 'status_aktif'], 'integer'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'harga' => 'Harga',
            'reff_bonus_poin' => 'Reff Bonus Poin',
            'keterangan' => 'Keterangan',
            'status_aktif' => 'Status Aktif',
        ];
    }
}
