<?php

namespace common\models;

use common\models\base\Base;
use Yii;

/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $cat_name
 */
class Cat extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_name' => Yii::t('app', 'Cat Name'),
        ];
    }

    /**
     * @return array
     * @throws \Exception
     * 获取所有分类
     */
    public static function getAllCats()
    {
        $cat = ['0' => '暂无分类'];
        $result = self::find()->asArray()->all();
        if(!$result)
        {
            throw new \Exception('数据库中没有数据');
        }else{
            foreach ( $result as $key => $data)
            {
                $cat[$data['id']] = $data['cat_name'];
            }
        }
        return $cat;
    }
}
