<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Session;
use App\Model\Yunreg;
use App\Model\Yuntemp;

class RegController extends Controller
{

    public $wechat;

    public function __construct(){
        $options=config("app.options");
        $this->wechat = new Application($options);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 注册页面
     * 微信静默授权
     * 2017-03-09
     */
    public function index()
    {
        if (!session('wechat_user')) {
            $oauth = $this->wechat->oauth;
            $response = $oauth->redirect()->send();
        }
        $user = session('wechat_user');
//        echo $user['id'];
        session(['openid'=>$user['id']]);
        $res = Yunreg::where(['openid'=>$user['id']])->first();
        if(!is_null($res))
            $result = array(
                'name'=>$res->name,
                'date'=>$res->date
            );
        else
            $result = array(
                'name'=>'',
                'date'=>''
            );
        return view("reg/index", ['data' => $result]);
    }

    /**
     * 静默授权回调函数
     * 2017-03-09
     */
    public function back(){
        $user = $this->wechat->oauth->user();
        session(['wechat_user'=>$user->toArray()]);
        header('location:'. '/reg');
    }

    /**
     * post
     * 用户注册，修改信息
     * 2017-03-09
     */
    public function reg(Request $request){
        $res = Yunreg::where(['openid'=>session('openid')])->first();
        $yunuser = new Yunreg();
        if(is_null($res)){
            $yunuser->openid = session('openid');
            $yunuser->name = $request->name;
            $yunuser->date = $request->date;
            $r = $yunuser->save();
            $m = $r?array('info'=>'注册成功'):array('info'=>'注册失败');
        }else{
            $r = $yunuser->where(['openid'=>session('openid')])->update(['name'=>$request->name,'date'=>$request->date]);
            $m = $r?array('info'=>'更新成功'):array('info'=>'更新失败');
            $this->sendMess();
        }
        echo json_encode($m);
    }

    /**
     * 发送模板消息
     * 注册成功之后发送
     * 2017-03-09
     */
    private function sendMess(){
        $notice = $this->wechat->notice;
        $userId = session('openid');
        $templateId = 'RtLERkSZ42KS0leMvrSpIOcIMG4AH0-rqBfmEajDc40';
        $url = 'http://overtrue.me';
        $data = array(
            "first"  => "恭喜你购买成功！",
            "key1"   => "巧克力",
            "key2"  => "39.8元",
            "end" => "欢迎再次购买！",
        );
        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        var_dump($result);
    }

    /**
     * 链接内容
     * 模板消息内容
     * 2017-03-09
     */
    public function media(Request $request, $id){
        $res = Yuntemp::where(['id'=>$id])->first(['content']);
        if($res)
            echo $res->content;
        else
            echo '不存在';
    }

    public function a(){
        //队列发送模板消息
        $user = Yunreg::get();
        foreach ($user as $v)
            echo $j = (time()-strtotime($v->date))/86400;
        exit;

        $notice = $this->wechat->notice;
        $res = Yuntemp::where(['id'=>'2'])->first();
        $userId = 'oUEeSs0cM9ZU7maCYxSkMr04PYSA';
        $templateId = $res->temid;
        $url = 'http://overtrue.me';
        $data = json_decode($res->data);
        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        var_dump($result);
    }
}