<?php

namespace App\Admin\Controllers;

use App\Models\Customer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CustomerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '病人信息';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Customer());
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('name', '姓名');
            $filter->like('in_no', '住院号');
        });
        
        $grid->expandFilter();

        $grid->column('name', '姓名');
        $grid->column('age', '年龄');
        $grid->column('sex', '性别')->using([1 => '男', 2=> '女']);
        $grid->column('company_name', '合作单位');
        $grid->column('in_no', '住院号');
        $grid->column('area', '病区');
        $grid->column('in_time', '住院时间');
        $grid->column('operate_time', '手术时间');
        $grid->column('out_time', '出院时间');
        $grid->column('main_diagnosis', '主诊断');
        $grid->column('main_doctor', '主治医生');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Customer::findOrFail($id));

        $show->field('name', '姓名');
        $show->field('age', '年龄');
        $show->field('sex', '性别')->options([1 => '男', 2=> '女']);
        $show->field('company_name', '合作单位');
        $show->field('in_no', '住院号');
        $show->field('area', '病区');
        $show->field('in_time', '住院时间');
        $show->field('operate_time', '手术时间');
        $show->field('out_time', '出院时间');
        $show->field('main_diagnosis', '主诊断');
        $show->field('main_doctor', '主治医生');
        $show->field('before_operate_score', '术前平分');
        $show->field('after_operate_score', '术后评分');
        $show->field('before_operate_image', '术前照片')->image();
        $show->field('after_operate_image', '术后照片')->image();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Customer());
        $form->footer(function ($footer) {
            // 去掉`重置`按钮
            $footer->disableReset();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();
        });
        

        $form->text('name', '姓名');
        $form->number('age', '年龄');
        $form->select('sex', '性别')->options([1 => '男', 2=> '女']);
        $form->text('company_name', '合作单位');
        $form->text('in_no', '住院号');
        $form->text('area', '病区');
        $form->date('in_time', '住院时间')->placeholder('住院时间')->format('YYYY-MM-DD');
        $form->date('operate_time', '手术时间')->placeholder('手术时间')->format('YYYY-MM-DD');
        $form->date('out_time', '出院时间')->placeholder('出院时间')->format('YYYY-MM-DD');
        $form->text('main_doctor', '主治医生');
        $form->textarea('main_diagnosis', '主诊断');
        $form->text('before_operate_score', '术前平分');
        $form->text('after_operate_score', '术后评分');
        $form->image('before_operate_image', '术前照片')->uniqueName()->removable();
        $form->image('after_operate_image', '术后照片')->uniqueName()->removable();

        return $form;
    }
}
