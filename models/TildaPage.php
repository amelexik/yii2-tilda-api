<?php

namespace globus\tilda\models;

use Yii;

/**
 * This is the model class for table "tilda_pages".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $project_id
 * @property integer $published
 * @property string $title
 * @property string $alias
 * @property string $html
 *
 * @property TildaImage[] $tildaImages
 * @property TildaScript[] $tildaScripts
 * @property TildaStyle[] $tildaStyles
 */
class TildaPage extends \yii\db\ActiveRecord
{
    /**
     * статусы
     */
    const STATUS_DEFAULT = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_ERROR = 3;

    public static function getStatusList()
    {
        return array(
            self::STATUS_DEFAULT => Yii::t('app','Статья еще не скачивалась'),
            self::STATUS_COMPLETED => Yii::t('app','Статья успешно скачана'),
            self::STATUS_IN_PROGRESS => Yii::t('app','Статья в процесе скачивания'),
            self::STATUS_ERROR => Yii::t('app','Произошла ошибка во время скачивания'),
        );
    }
    
    
    public static function checkConnection(){
        try{
            \Yii::$app->db->createCommand("DO 1")->execute();
        }catch (\yii\db\Exception $e){
            \Yii::$app->db->close();
            \Yii::$app->db->open();
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tilda_pages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'project_id', 'published', 'status'], 'integer'],
            [['html'], 'string'],
            [['title', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'page_id' => Yii::t('app', 'Page ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'published' => Yii::t('app', 'Published'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'html' => Yii::t('app', 'Html'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTildaImages()
    {
        return $this->hasMany(TildaImage::className(), ['tilda_page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTildaScripts()
    {
        return $this->hasMany(TildaScript::className(), ['tilda_page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTildaStyles()
    {
        return $this->hasMany(TildaStyle::className(), ['tilda_page_id' => 'id']);
    }

    public function replaceImg($from, $to)
    {
        $this->html = str_replace($from, $to, $this->html);
    }
}
