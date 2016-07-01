<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/8 0008
 * Time: 10:19
 *
 * 只显示上下按钮的简单翻页小部件
 */

namespace common\widgets;

use yii\base\Widget;
use yii\data\Pagination;

class SimplePagerWidget extends Widget
{
    public $pagination;

    public function run()
    {
        $out = '<nav class="pagination" role="navigation">';
        if(isset($this->pagination->links[Pagination::LINK_PREV]))
        {
            $out .= "\n" . '<a class="newer-posts" href="' . $this->pagination->links[Pagination::LINK_PREV] . '"><i class="fa fa-angle-left"></i></a>';
        }
        $out .= "\n" . '<span class="page-number">第 ' . ($this->pagination->page + 1) .' 页 &frasl; 共 ' . $this->pagination->pageCount . ' 页</span>';
        if(isset($this->pagination->links[Pagination::LINK_NEXT]))
        {
            $out .= "\n" . '<a class="older-posts" href="' . $this->pagination->links[Pagination::LINK_NEXT] . '"><i class="fa fa-angle-right"></i></a>';
        }
        $out .= "\n" . '</nav>';
        return $out;

    }
}