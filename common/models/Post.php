<?php

namespace common\models;

use common\models\base\Base;
use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $cat_id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property integer $created_at
 * @property integer $updated_at
 */
class Post extends Base
{
    const NOT_VALID = 0; // 未发布
    const IS_VALID = 1; // 发布
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['cat_id', 'user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * 获取 Post 的关联数组
     */
    public function getRelate()
    {
        return $this->hasMany(RelationPostTag::className(), ['post_id' => 'id']); // 文章的 id
    }
    public function getExtend()
    {
        return $this->hasOne(PostExtend::className(), ['post_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增ID'),
            'title' => Yii::t('app', '标题'),
            'summary' => Yii::t('app', '摘要'),
            'content' => Yii::t('app', '内容'),
            'label_img' => Yii::t('app', '标签图'),
            'cat_id' => Yii::t('app', '分类id'),
            'user_id' => Yii::t('app', '用户id'),
            'user_name' => Yii::t('app', '用户名'),
            'is_valid' => Yii::t('app', '是否有效：0-未发布 1-已发布'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }
}
