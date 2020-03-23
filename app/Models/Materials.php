<?php
/**
 * Created by PhpStorm.
 * User: wentao
 * Date: 2020/3/7
 * Time: 17:04
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    protected $table = 'material';
    protected $guarded = ['id'];

    public static function getMaterialByClassId($class_id)
    {
        if ($class_id) {
            $data = Materials::where(['class_id' => $class_id, 'status' => 1, 'is_del' => 0])
                ->select('id','content','status','link','type','class_id','time')
                ->orderBy('id','desc')
                ->paginate(10);
        } else {
            $data = Materials::where(['status' => 1, 'is_del' => 0])
                ->select('id','content','status','link','type','class_id','time')
                ->orderBy('id','desc')
                ->paginate(10);
        }
        foreach($data as &$value){
            $image_data=$value['link']??[];
            foreach ($image_data as &$img_value){
                $img_value='https://'.$_SERVER['HTTP_HOST'].'/upload/'.$img_value;
            }
          	$value['link']=$image_data;
          	$value['time']=date("Y-m-d H:i:s",$value['time']);
        }
        return $data;
    }

    public static function getMaterialById($id){

        $data = Materials::where(['id'=>$id,'status' => 1, 'is_del' => 0])
            ->select('id','content','status','link','type','class_id')
            ->first();
        if($data){  	
            $image_data=$data['link']??[];
            foreach ($image_data as &$img_value){
                $img_value='https://'.$_SERVER['HTTP_HOST'].'/upload/'.$img_value;
            }
            $data['link']=$image_data;
            $data['time']=date("Y-m-d H:i:s",$data['time']); 
        }
        return $data;
    }

    public function setLinkAttribute($image)
    {
        if (is_array($image)) {
       		$this->attributes['link'] = json_encode($image);
        }
    }

    public function getLinkAttribute($image)
    {
        $image_data=json_decode($image, true);
//        foreach ($image_data as &$value){
//            $value=$_SERVER['SERVER_NAME'].'/'.$value;
//        }
        return $image_data;
    }

}