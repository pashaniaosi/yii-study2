<?php

namespace common\models;

use common\models\base\Base;
use Yii;

/**
 * This is the model class for table "post_extends".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $browser
 * @property integer $collect
 * @property integer $praise
 * @property integer $comment
 */
class PostExtend extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'browser' => Yii::t('app', 'Browser'),
            'collect' => Yii::t('app', 'Collect'),
            'praise' => Yii::t('app', 'Praise'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * 实现文章浏览次数的统计
     */
    public function upCounter($condition, $attribute, $number)
    {
//        查找是否有相应的数据, 比如该篇文章是否有浏览记录, 是否有人收藏等等
        $counter = $this->findOne($condition);
        if (!$counter)
//        创建记录
        {
//            如果没有相应的记录, 则新建一条记录
            $this->setAttributes($condition);
//            初始化各个属性的值, 不同属性的值可能不同, 比如有浏览量不一定会有点赞量和评论量
            $this->attributes = $number;
//            保存数据
            $this->save();
        }else{
//            更新记录
            $countData[$attribute] = $number;
//            将要更新的属性和要更新的值赋给 updateCounters() 这个方法, 就可以自动完成对该属性的值的更新
            $counter->updateCounters($countData);
        }
    }
}
