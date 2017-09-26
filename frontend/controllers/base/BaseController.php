<?php
/**
 * Created by PhpStorm.
 * User: lukace
 * Date: 9/25/17
 * Time: 3:20 PM
 */
namespace frontend\controllers\base;

use yii\web\Controller;
/**
 * Class BaseController
 * @package app\controllers\base
 * 基础控制器
 */
class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action))
        {
            return false;
        }
        return true;
    }
}