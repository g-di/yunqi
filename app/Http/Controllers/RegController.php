<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use EasyWeChat\Foundation\Application;
use Session;
use App\Model\Yunreg;
use App\Model\Yuntemp;

class RegController extends Controller
{

    public $wechat;

    public function __construct()
    {
        $options = config("app.options");
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
        session(['openid' => $user['id']]);
        $res = Yunreg::where(['openid' => $user['id']])->first();
        if (!is_null($res))
            $result = array(
                'name' => $res->name,
                'date' => $res->date
            );
        else
            $result = array(
                'name' => '',
                'date' => ''
            );
        return view("reg/index", ['data' => $result]);
    }

    /**
     * 静默授权回调函数
     * 2017-03-09
     */
    public function back()
    {
        $user = $this->wechat->oauth->user();
        session(['wechat_user' => $user->toArray()]);
        header('location:' . '/reg');
    }

    /**
     * post
     * 用户注册，修改信息
     * 2017-03-09
     */
    public function reg(Request $request)
    {
        $res = Yunreg::where(['openid' => session('openid')])->first();
        $yunuser = new Yunreg();
        $request->ip = ($request->ip)?$request->ip:$this->getClientIP();
        if(!$request->cname){
            $cname = $this->getCity($request->ip);
            $request->cname = $cname['country'].' '.$cname['region'].' '.$cname['city'].' '.$cname['isp'];
        }
        if (is_null($res)) {
            $yunuser->openid = session('openid');
            $yunuser->name = $request->name;
            $yunuser->date = $request->date;
            $yunuser->ip = $request->ip;
            $yunuser->cname = $request->cname;
            $yunuser->device = $request->device;
            $r = $yunuser->save();
            $m = $r ? array('info' => '注册成功') : array('info' => '注册失败');
        } else {
            $r = $yunuser->where(['openid' => session('openid')])->update(['name' => $request->name, 'date' => $request->date,'ip'=>$request->ip,'cname'=>$request->cname,'device'=>$request->device]);
            $m = $r ? array('info' => '更新成功') : array('info' => '更新失败');
        }
        echo json_encode($m);
    }
    /**
     * 客户端未发送ip，后台获取
     * gd
     * 2017-03-20
     */
    private function getClientIP()
    {
        global $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else $ip = "Unknow";
        return $ip;
    }
    /**
     * 后台获取地理位置
     * gd
     * 2017-03-20
     */
    private function getCity($ip = '')
    {
        if($ip == ''){
            $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
            $ip=json_decode(file_get_contents($url),true);
            $data = $ip;
        }else{
            $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
            $ip=json_decode(file_get_contents($url));
            if((string)$ip->code=='1'){
                return false;
            }
            $data = (array)$ip->data;
        }

        return $data;
    }
    /**
     * 发送模板消息
     * 注册成功之后发送
     * 2017-03-09
     */
    private function sendMess()
    {
        $notice = $this->wechat->notice;
        $userId = session('openid');
        $templateId = 'RtLERkSZ42KS0leMvrSpIOcIMG4AH0-rqBfmEajDc40';
        $url = 'http://overtrue.me';
        $data = array(
            "first" => "恭喜你购买成功！",
            "key1" => "巧克力",
            "key2" => "39.8元",
            "end" => "欢迎再次购买！",
        );
        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
//        var_dump($result);
    }

    /**
     * 链接内容
     * 模板消息内容
     * 2017-03-09
     */
    public function media(Request $request, $id)
    {
        $res = Yuntemp::where(['id' => $id])->first(['content']);
        if ($res)
            echo $res->content;
        else
            echo '不存在';
    }

    public function send()
    {
        $date = Redis::get('send:date');
        if ($date != date('Y-m-d', time())) {
            //N周以前的日期
            for ($i = 1; $i <= 40; $i++) {
                $a = date('Y-m-d', (time() - 86400 * $i * 7));
                //查出第N周的人openID
                $u = Yunreg::where(['date' => $a])->get(['openid']);
                if (count($u) > 0) {
                    $u['id'] = $i;
                    $res[] = $u;
                }

            }
            foreach ($res as $k => $v) {
//      查询对应的模板消息
                $temp = Yuntemp::where(['num' => $v['id']])->first();
                unset($res[$k]['id']);
//      发送模板消息
                $notice = $this->wechat->notice;
                foreach ($v as $value) {
                    $userId = $value['openid'];
                    $templateId = $temp->temid;
                    $url = 'http://laravel.shanheweb.com/yun/' . $temp->id;
                    $data = json_decode($temp->data);
                    $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
                    var_dump($result);
                }
            }
            Redis::set('send:date', date('Y-m-d', time()));
        }
    }
}