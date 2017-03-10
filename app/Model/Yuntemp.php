<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017/3/9
 * Time: 15:17
 */

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Yuntemp extends Model
{
    protected $table='yun_temp';
    use SoftDeletes;

}