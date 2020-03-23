<?php
/**
 * Created by PhpStorm.
 * User: wentao
 * Date: 2020/3/7
 * Time: 10:03
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\MaterialClasses;
use App\Models\Materials;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $class_id = $data['class_id'] ?? 0;
        //获取素材的分类
        $material_class = MaterialClasses::getAllClass();
        //获取首页的素材
        $material = Materials::getMaterialByClassId($class_id);
        $data=[
            'material_class'=>$material_class,
            'material'=>$material
        ];
        return $this->success($data);
    }

    public function show(Request $request)
    {
        $data = $request->all();
        $material_id = $data['material_id'];
        //获取指定素材
        $material = Materials::getMaterialById($material_id);
        return $this->success($material);
    }
}