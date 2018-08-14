<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $table = 'article';

    protected $fillable = ['nav_id','cg_id','labels','cover','title','intro','author','publish_time','status','content'];

    //上一篇
    public static function prev($id,$nav_id){
        $article = DB::select("SELECT id, title FROM hg_article WHERE id = (SELECT max(id) FROM hg_article WHERE id < $id AND nav_id=$nav_id)");
        return $article;
    }

    //下一篇
    public static function next($id,$nav_id){
        $article = DB::select("SELECT id, title FROM hg_article WHERE id = (SELECT min(id) FROM hg_article WHERE id > $id AND nav_id=$nav_id)");
        return $article;
    }

    //猜你喜欢
    public static function guessLike($labels){
//        DB::connection()->enableQueryLog(); // 开启查询日志
        $labelArr = explode(',',$labels);
        $labwhere = '';
        foreach ($labelArr as &$v){
            if ($labwhere){
                $labwhere .= 'or instr(labels, "'.$v.'") > 0 ';
            }else{
                $labwhere .= 'instr(labels,"'.$v.'") > 0 ';
            }
        }
        $art = DB::select('SELECT id,title,cover FROM hg_article WHERE '.$labwhere);
//        $art = DB::select("SELECT id,title,cover FROM hg_article WHERE labels like '%流浪汉%'");
//        dd($art);
//        $art = self::select('id','title','cover')->where('labels','like',$labelArr)->limit(8);
//        $bindings = $art->getBindings();
//        $sql = str_replace('?', '%s', $art->toSql());
//        $sql = sprintf($sql, ...$bindings);
//        $queries = DB::getQueryLog();
//        dd($queries);
//        dd($art);
        return $art;
    }
}
