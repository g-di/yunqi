<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017/3/9
 * Time: 14:40
 */

namespace App\Http\Controllers;

use EasyWeChat\Message\Location;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Request;
use App\Model\Yunreg;
use App\Model\Yuntemp;
use Tld\Wechat\Model\Template;
use Tld\Wechat\Model\Template_data;

class YunController extends Controller
{
    /**
     * 用户注册页面
     */
    public function index(){
        $where = array();
        $list = Yunreg::where($where)->paginate(20);

        return view("yun.index", ['list' => $list]);
    }

    public function temp(){
        $where = array();
        $list = Yuntemp::join('templates','templates.template_id','=','yun_temp.temid')->where($where)->select(['*','yun_temp.created_at','yun_temp.id'])->orderBy('num','ASC')->paginate(20);
        return view("yun.temp", ['list' => $list]);
    }

    public function tempadd(){
        $list = Template::paginate(20);
        return view("yun.tempadd", ['list' => $list]);
    }
    public function tempinfo(Request $request){
        $list =Template_data::where(['t_id'=>$request->id])->get()->toJson();
        echo $list;
    }

    public function tempadds(Request $request){
        $temid = Template::where(['id'=>$request->tid])->first(['template_id']);
        for($i=0;$i<11;$i++){
            $b = 'gdk'.$i;
            $a = 'gdkey'.$i;
            if(!isset($request->$a))
                break;
            $data[$request->$b]=$request->$a;
        }
        $yuntemp = new Yuntemp();
        $yuntemp->temid = $temid->template_id;
        $yuntemp->num = $request->num;
        $yuntemp->content = $request->content;
        $yuntemp->data = json_encode($data);
        $yuntemp->save();
        header('location:'. '/yun/temp');
    }
}