<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penulis".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telepon
 * @property string $email
 */
class Penulis extends \yii\db\ActiveRecord
{

    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penulis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['alamat'], 'string'],
            [['nama', 'telepon', 'email'], 'string', 'max' => 255],
             ['email', 'unique'], // Membuat nama menjadi uniq atau di buat satu kali buat validasi di from.
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
            'alamat' => 'Alamat',
            'telepon' => 'Telepon',
            'email' => 'Email',
        ];
    }

  public function findAllBuku()
{
    return Buku::find()
    ->andWhere(['id_penulis' => $this->id])
    ->all();
}

public function getJumlahBuku()
{
    return Buku::find()
    ->andWhere(['id_penulis' => $this->id])
    ->count();
}
public function getPenulisCount()
{
     return static::find()->count();
}

 public static function getGrafikList()
    {
        $data = [];
        foreach (static::find()->all() as $penulis) {
            $data[] = [$penulis->nama, (int) $penulis->getManyBuku()->count()];
        }
        return $data;
    }

 public function getManyBuku()
    {
        return $this->hasMany(Buku::class, ['id_penulis' => 'id']);
    }

}

