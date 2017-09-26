<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 15:07
 */

namespace frontend\models;

use common\models\Tag;
use Yii;
use yii\base\Model;

/**
 * Class TagForm
 * @package app\models
 * 标签的表单模型
 */

class TagForm extends Model
{
    public $id;
    public $tags;

    public function rules()
    {
        return [
            ['tags', 'required'],
            ['tags', 'each', 'rule' => ['string']],
        ];
    }

    /**
     * @return array
     * 保存标签集合
     */
    public function saveTags()
    {
        $ids = [];
        if( !empty($this->tags))
        {
            foreach ($this->tags as $tag)
            {
                $ids[] = $this->_saveTag($tag);
            }
        }
//        返回所有的标签 id
        return $ids;
    }

    /**
     * 保存标签
     */
    private function _saveTag($tag)
    {
        $model = new Tag();
//        查询是否有重复的标签
        $result = $model->find()->where(['tag_name' => $tag])->one();

//        创建标签
        if(!$result)
        {
//            如果没有重复的标签名, 则新建一条标签名
            $model->tag_name = $tag;
            $model->post_num = 1;
//            判断标签保存成功与否
            if(!$model->save())
                throw new \Exception(Yii::t('app', '标签保存失败'));

            return $model->id;
        }else{
//            如果有重复的标签名, 则将 post_num 加一
            $result->updateCounters(['post_num' => 1]);
        }

//        返回标签的 id
        return $result->id;
    }
}