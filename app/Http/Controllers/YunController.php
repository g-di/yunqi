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
    const sum = 40;//共40周

    /**
     * 用户注册页面
     */
    public function index()
    {
        $where = array();
        $list = Yunreg::where($where)->paginate(20);

        return view("yun.index", ['list' => $list]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 模板素材列表
     */
    public function temp()
    {
        $where = array();
        $list = Yuntemp::join('templates', 'templates.template_id', '=', 'yun_temp.temid')->where($where)->select(['*', 'yun_temp.updated_at', 'yun_temp.id'])->orderBy('num', 'ASC')->paginate(20);
        return view("yun.temp", ['list' => $list]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 添加发送模板
     */
    public function tempadd()
    {
        $list = Template::get();
        $num = Yuntemp::orderBy('num', 'asc')->get(['num'])->toArray();
        $number = array();
        foreach ($num as $v) {
            $number[] = $v['num'];
        }
        $number = array_unique($number);
        if (count($number) < self::sum)
            return view("yun.tempadd", ['list' => $list, 'num' => $number, 'sum' => self::sum]);
        else
            return redirect("/yun/temp")->withErrors("期数已满");
    }

    /**
     * @param Request $request
     * ajax post
     * 获取模板消息
     */
    public function tempinfo(Request $request)
    {
        $list = Template_data::where(['t_id' => $request->id])->get()->toJson();
        echo $list;
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * post
     * 添加发送模板
     */
    public function tempadds(Request $request)
    {
        $temid = Template::where(['id' => $request->tid])->first(['template_id']);
        for ($i = 0; $i < 11; $i++) {
            $b = 'gdk' . $i;
            $a = 'gdkey' . $i;
            if (!isset($request->$a))
                break;
            $data[$request->$b] = $request->$a;
        }
        $yuntemp = new Yuntemp();
        $yuntemp->temid = $temid->template_id;
        $yuntemp->num = $request->num;
        $yuntemp->content = $request->content;
        $yuntemp->data = json_encode($data);
        $res = $yuntemp->save();
        if ($res) {
            return redirect("/yun/temp")->with("messages", ['0' => "添加成功"]);
        } else {
            return redirect("/yun/temp")->withErrors("添加失败");
        }
    }

    /**
     * 删除模板消息
     * gd
     * 2017-03-20
     */
    public function tempdel($id)
    {
        $temp = new Yuntemp();
        $data = $temp->find($id);
        $data->delete();
        if ($data->trashed()) {
            return redirect("/yun/temp")->with("messages", ['0' => "删除成功"]);
        } else {
            return redirect("/yun/temp")->withErrors("删除失败");
        }
    }

    /**
     * 修改模板
     * 2017-03-23
     */
    public function tempupd($id)
    {
        $list = Template::get();
        $temp = Yuntemp::where(['id' => $id])->first()->toArray();
        $info = Yuntemp::join('templates', 'yun_temp.temid', '=', 'templates.template_id')
            ->join('template_data', 'templates.id', '=', 'template_data.t_id')
            ->where(array('yun_temp.id' => $id))
            ->get(['template_data.*', 'templates.*']);
        return view("yun.tempupd", ['list' => $list, 'temp' => $temp, 'info' => $info]);
    }
    /**
     * 修改模板
     * 2017-03-23
     */
    public function tempupds(Request $request)
    {
        $temid = Template::where(['id' => $request->tid])->first(['template_id']);
        for ($i = 0; $i < 11; $i++) {
            $b = 'gdk' . $i;
            $a = 'gdkey' . $i;
            if (!isset($request->$a))
                break;
            $data[$request->$b] = $request->$a;
        }
        $yuntemp = new Yuntemp();
        $update = array(
            'temid' => $temid->template_id,
            'content' => $request->content,
            'data' => json_encode($data)
        );
        $res = $yuntemp->where(array('num'=>$request->num))->update($update);
        if ($res) {
            return redirect("/yun/temp")->with("messages", ['0' => "修改成功"]);
        } else {
            return redirect("/yun/temp")->withErrors("修改失败");
        }
    }
}