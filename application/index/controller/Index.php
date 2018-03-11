<?php
namespace app\index\controller;
use think\Request;
use think\Validate;
use think\Db;

class Index
{
    public function index()
    {
    	// 实例化
    	$request = Request::instance();
    	// 判断是什么请求方式
    	if ($request -> isGet()) {
    		echo '是get哈哈哈';
    	}
    	if ($request -> isPost()) {
    		echo '是post';
    	}
    	if ($request -> isPut()) {
    		echo '是Put';
    	}
    	if ($request -> isDelete()) {
    		echo '是Delete';
    	}  
    }

    public function getUserInfo()
    {
        $request = Request::instance();
        // dump($request->param('a'));
        // dump($request);
        // exit;
        $user = Db::table('user')->select();
        // dump($user); 
        // exit;
        $data = array(
            'code' => '1',
            'msg'  => '失败',
            'data' => $user
        );
    	return $data;  
        // echo Db::query('select * from user where id=1');
    }
}
