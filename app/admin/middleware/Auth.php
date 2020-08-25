<?php


namespace app\admin\middleware;


use think\response\Redirect;

class Auth
{
    public function handle($request,\Closure $next)
    {
        $session = session(config('admin.session_admin'));
        if (empty($session) && !preg_match('/login/',$request->pathinfo())){
            return redirect(url('login/index'));
        }

        if ($session && preg_match('/login/',$request->pathinfo())){
            return redirect(url('index/index'));
        }
        return $next($request);
    }

}