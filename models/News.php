<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 *
 */
class News extends ActiveRecord
{
    public static function tableName()
    {
      return '{{%news}}';
    } //end tableName()

    public function rules()
     {
         return [
             [['title', 'body', 'image', 'created_at', 'created_by'], 'required'],
             [['title', 'body', 'image'], 'string'],
             [['created_at'], 'string', 'max' => 100],
             [['image'], 'string', 'max' => 100],
         ];
     }

     public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
            'image' => 'Image',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
