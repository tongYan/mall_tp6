<?php
namespace app\admin;

use think\exception\Handle;
//use think\exception\HttpException;
use think\Response;
use Throwable;


/**
 * 应用异常处理类
 */
class Http extends Handle
{
    protected $http_status =500 ;

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        if (method_exists($e,'getStatusCode')){
            $status =$e->getStatusCode();
        } else {
            $status = $this->http_status;
        }


        return show(config('status.error'),$e->getMessage(),[],$status);
        // 其他错误交给系统处理
//        return parent::render($request, $e);
    }
}
