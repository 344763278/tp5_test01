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

    //获取数据
    public function getData()
    {
        // 分页
        $start = Request::instance()->param('pageIndex'); 
        $pageSize = Request::instance()->param('pageSize');  
        $name = Request::instance()->param('name');  
        $map['name'] = array('like' ,'%'.$name.'%'); 
        $sql = 'select * from data_tables where name like "%'.$name.'%" limit '.($start-1)*$pageSize.','.$pageSize;
        $data = Db::query($sql);   
        $all = db('data_tables')->where($map)->select();
        $total = count($all); 
        $req = [
            'data' => $data,
            'total' => $total
        ];
        if (count($data)) {
            return $this->sendMsg($req, '0', '查询成功');
        } else if (count($data) == 0) {
            return $this->sendMsg([], '0', '数据库无数据');
        } else {
            return $this->sendMsg([], '1', '数据库错误');
        }   
    }

     
    //编辑数据
    public function edit()
    {
        $request = Request::instance(); 
        $time = $request->param('time'); 
        $name = $request->param('name'); 
        $address = $request->param('address'); 
        $status = $request->param('status');  
        $id = $request->param('id');  

        $res=db('data_tables')->where(array('id'=>$id))->update(array(
            'name' => $name,
            'time' => $time,
            'address' => $address,
            'status' => $status,
        ));   
        if ($res == 1) {
            return $this->sendMsg([], '0', '编辑成功');
        } else {
            return $this->sendMsg([], '1', '编辑失败');
        }     
    }

    // 启用和禁用
    public function able()
    {
        $request = Request::instance(); 
        $id = $request->param('id');  
        $status = $request->param('status');   

        $res=db('data_tables')->where(array('id'=>$id))->update(array( 
            'status' => $status,
        ));   
        if ($res == 1) {
            if ($status == '0') {
                return $this->sendMsg([], '0', '启用成功');
            } else {
                return $this->sendMsg([], '0', '禁用成功');
            }
            
        } else {
            return $this->sendMsg([], '1', '启用禁用失败');
        }     
    }

    // 删除
    public function del()
    {
        $request = Request::instance(); 
        $id = $request->param('id'); 
        if (!$id) {
            return $this->sendMsg([],'1', 'id是必传的');
        };
        $res = db('data_tables')->where(array('id'=>$id))->delete(); 
        // dump($res);
        if ($res == 1) {
            return $this->sendMsg([],'0', '删除成功');
        } else {
            return $this->sendMsg([],'1', '删除失败');
        }
        return;     
    }

    // 新增
    public function add()
    {
        $request = Request::instance(); 
        $time = $request->param('time'); 
        $name = $request->param('name'); 
        $address = $request->param('address'); 
        $status = $request->param('status'); 

        $data = ['time' => $time, 'name' => $name, 'address' => $address, 'status' => $status];
        $res = DB::name('data_tables')->insert($data); 
        // dump($res); 
        if ($res) {
            return $this->sendMsg([],'0', '添加成功');
        } else {
            return $this->sendMsg([],'1', '添加失败');
        }    
    }

    // 封装返回函数
    public function sendMsg($data=[], $code='0', $msg='成功')
    {
        return json(array(
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ));
    }
}
