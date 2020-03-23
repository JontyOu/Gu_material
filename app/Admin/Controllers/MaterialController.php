<?php

namespace App\Admin\Controllers;

use App\Models\Materials;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MaterialController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '素材管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Materials());

        $grid->column('id', __('Id'));
      	$grid->model()->orderBy('id', 'desc');
        $grid->column('content', '内容')->display(function ($content){
            if(strlen($content)>21){
                return substr($content,0,21).'……';
            }
            return $content;
        });
        $grid->column('link', __('图片/视频'))->display(function ($link){
            $html_str='';
          	$link=$link?? [];
            if(sizeof($link)<3){
                foreach ($link as &$value){
                    $value=env('APP_URL').'/upload/'.$value;
                    $html_str.="<img src='{$value}' alt='' height='50' width='50' style='margin: 1px' >";
                }
            }elseif (sizeof($link)==4){
                foreach ($link as $key=>&$value){
                    $value=env('APP_URL').'/upload/'.$value;
                    $html_str.="<img src='{$value}' alt='' height='50' width='50' style='margin: 1px' >";
                    if(($key+1)%2==0){
                        $html_str.="<br>";
                    }
                }
            }else{
                foreach ($link as $key=>&$value){
                    $value=env('APP_URL').'/upload/'.$value;
                    $html_str.="<img src='{$value}' alt='' height='50' width='50' style='margin: 1px' >";
                    if(($key+1)%3==0){
                        $html_str.="<br>";
                    }
                }
            }
            return $html_str;
        });
        $grid->column('type', __('类型'));
        $grid->column('time', __('时间'))->display(function($time){
          return date('Y-m-d H:i:s',$time);
        });
        $grid->column('class_id', __('分类'));
        $grid->column('status', __('状态'))->switch([
          'on'  => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
          'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
    	]);;
//        $grid->column('is_del', __('Is del'));
//        $grid->column('created_at', __('Created at'));
//        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Materials::findOrFail($id));

//        $show->field('id', __('Id'));
//        $show->field('内容', __('Content'));
//        $show->field('图片/视频', __('Link'));
//        $show->field('类型', __('Type'));
//        $show->field('时间', __('Time'));
//        $show->field('分类', __('Class id'));
//        $show->field('状态', __('Status'));
//        $show->field('is_del', __('Is del'));
//        $show->field('created_at', __('Created at'));
//        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Materials());

        $form->textarea('content', __('内容'));
        $form->multipleImage('link', '图片/视频')->uniqueName()->removable();
//        $form->textarea('link', __('图片/视频'));
        $form->switch('type', __('类型'));
        $form->display('time', __('时间'))->with(function($time){
           return date('Y-m-d H:i:s',$time);
        });
        $form->number('class_id', __('类别'));
        $form->switch('status', __('状态'))->default(1);
//        $form->switch('is_del', __('Is del'));
        $form->saving(function (Form $form) {
              $time = $form->time;
              if (!$time) {
                  $form->time=time();
              }else{
                  $form->time=strtotime($time);
              }
          });
        return $form;
    }
}
