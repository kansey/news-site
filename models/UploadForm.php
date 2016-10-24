<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\News;
use yii\helpers\Url;

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
            $url       =  Url::to('uploads/' . $this->image->baseName . '.' . $this->image->extension );
            $newsModel = new News();

            $values = [
                'title' => $this->title,
                'body' => $this->body,
                'image' => $url,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => \Yii::$app->user->identity->id
            ];
            
            $newsModel->attributes = $values;
            return ($newsModel->save() ? true : false);
         } else {
             return false;
         }
    }
}
