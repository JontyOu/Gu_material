<?php
/**
 * Created by PhpStorm.
 * User: wentao
 * Date: 2020/3/7
 * Time: 17:04
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialClasses extends Model
{
    protected $table = 'material_class';
    protected $guarded = ['id'];

    public static function getAllClass()
    {
        $data = MaterialClasses::where(['status' => 1, 'is_del' => 0])->select('id','name','status')->get();
        return $data;
    }

}