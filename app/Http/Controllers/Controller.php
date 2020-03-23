<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $statusCode = 200;

//    protected function success($data='',$code=0,$message='success'){
//        $return_data=[
//            'status'=>$code,
//            'data'=>array($data),
//            'message'=>$message,
//        ];
//        return json_encode($return_data,true);
//    }

    public function success($data, $status = "success"){

        return $this->status($status,compact('data'));
    }

    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST,$status = 'error'){

        return $this->setStatusCode($code)->message($message,$status);
    }

    public function status($status, array $data, $code = null){

        if ($code){
            $this->setStatusCode($code);
        }
        $status = [
            'status' => $status,
            'code' => $this->statusCode
        ];

        $data = array_merge($status,$data);
        return $this->respond($data);

    }

    public function setStatusCode($statusCode,$httpCode=null)
    {
        $httpCode = $httpCode ?? $statusCode;
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respond($data, $header = [])
    {

        return Response::json($data,$this->getStatusCode(),$header);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
