<?php
/**
 * Created by PhpStorm.
 * User: lukace
 * Date: 9/26/17
 * Time: 3:02 PM
 */

namespace common\models\base;

use yii\db\ActiveRecord;

/**
 * Class Base
 * @package 基础模型
 */
class Base extends ActiveRecord
{
    /**
     * @param $query
     * @param int $curPage
     * @param int $pageSize
     * @param null $search
     * @return array
     * 获取分页的数据
     */
    public function getPages($query, $curPage = 1, $pageSize = 5, $search = null)
    {
//        搜索功能, 待完成
        if($search)
            $query = $query->andFilterWhere($search);
        $data['count'] = $query->count();
//        如果 data 是个空数组, 则返回以下数组
        if(!$data['count'])
        {
            return ['count' => 0, 'curPage' => $curPage, 'pageSize' => $pageSize, 'start' => 0, 'end' => 0,
                'data' => []
            ];
        }
//        如果要访问的页数大于最大的页数, 则返回最大的页数
        $curPage = (ceil($data['count']/$pageSize)<$curPage)
            ?ceil($data['count']/$pageSize):$curPage;
//        要访问的页数
        $data['curPage'] = $curPage;
//        每页显示的条数
        $data['pageSize'] = $pageSize;
//        当前页开始显示的位置
        $data['start'] = ($curPage-1)*$pageSize+1;
//        当前页结束显示的位置
        $data['end'] = (ceil($data['count']/$pageSize) == $curPage)
            ?$data['count']:$curPage*$pageSize;
//        查询数据
        $data['data'] = $query
            ->offset(($curPage-1)*$pageSize)
            ->limit($pageSize)
            ->asArray()
            ->all();
        return $data;
    }
}