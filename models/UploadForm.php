<?php
namespace app\models;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\News;

/**
 *
 */
class UploadForm extends Model
{
    public $image;
    public $title;
    public $body;

    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'min' => 10],
            ['body', 'required'],
            ['body', 'string', 'min' => 10],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
       ];
    }

    public function upload()
    {
        if ($this->validate()) {
             $this->image->saveAs('uploads/' . $this->image->baseName . '.' . $this->image->extension);
         }
    }
}
