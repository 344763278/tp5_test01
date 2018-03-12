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

    public function getData()
    {
        $request = Request::instance();
        // dump($request->param('a'));
        // dump($request);
        // exit;
        $user = Db::table('data_table')->select();
        // dump($user); 
        // exit;
        $data = array(
            'code' => '0',
            'msg'  => '成功',
            'data' => $user
        );
    	return $data;  
        // echo Db::query('select * from user where id=1');
    }

    public function search()
    {
        $request = Request::instance(); 
        $name = $request->param('name'); 
        $data = Db::query('select * from data_table where name="'.$name.'"'); 
        // $data = Db::table('data_table')->where('name',$name)->find();
        dump($data); 
         
        return $this->sendMsg($data);    
    }

    public function del()
    {
        $request = Request::instance(); 
        $id = $request->param('id'); 
        $data = Db::query('delete from data_table where id="'.$id.'"'); 
        //找id然后删除 
        // $res = Db::table('data_table')->where('id',$id)->delete();
        // dump($res);  
        return $this->sendMsg($data);    
    }

    public function add()
    {
        $request = Request::instance(); 
        $time = $request->param('time'); 
        $name = $request->param('name'); 
        $address = $request->param('address'); 

        $data = ['time' => $time, 'name' => $name, 'address' => $address, 'id' => '9', 'status' => '0'];
        var_dump($data);  
        $res = Db('data_table') -> insert($data);
        if ($res) {
            return $this->sendMsg([],'0', '添加成功');
        } else {
            return $this->sendMsg([],'1', '添加失败');
        }    
    }

    public function sendMsg($data=[], $code='0', $msg='成功')
    {
        return array(
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        );
    }
}
