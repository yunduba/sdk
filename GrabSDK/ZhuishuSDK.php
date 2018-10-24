<?php
/**
 * Created by QQ39818148.
 * User: mac-39818148
 * Date: 2018/10/24
 * Time: 下午5:01
 */
namespace yunduba\SDK\GrabSDK;

use QL\QueryList;
use yunduba\SDK\Grab;

class ZhuishuSDK{
    /**
     * @var string 书籍列表抓取地址
     */
    const ListsUrl='http://api.zhuishushenqi.com/book/by-categories';
    const InfoUrl='http://api.zhuishushenqi.com/book/';
    const ImageUrl='http://statics.zhuishushenqi.com';

    public function __construct()
    {
        //初始化SDK
    }

    public static function getBookLists($gender,$column_name,$son_column_name,$type='new',$start=0,$limit=50){
        $data['gender']=$gender;
        $data['major']=$column_name;
        $data['minor']=$son_column_name;
        $data['type']=$type;
        $data['start']=$start;
        $data['limit']=$limit;
        $book_lists=QueryList::get(self::ListsUrl,$data)->getHtml();
        $book_lists=Grab::isJson($book_lists);
        if ($book_lists || $book_lists['ok']){
            foreach ($book_lists as $key=>$val){
                $lists_data[$key]=$val['_id'];
            }
            return $lists_data;
        }else{
            return false;
        }
    }

    public static function getBookInfo($id){
        $book_info=QueryList::get(self::InfoUrl.$id)->getHtml();
        $book_info = Grab::isJson($book_info);
        if ($book_info || $book_info['ok']){
            $info_data['book_cover']=self::ImageUrl.$book_info['cover'];
            //处理tag
            if(!empty($book_info['tags'])){
                $info_data['tag']=implode(',',$book_info['tags']);
            }
            $info_data['book_is_api']=1;
            $info_data['book_api_id']=$book_info['_id'];
            $info_data['book_name']=$book_info['title'];
            $info_data['author_name']=$book_info['author'];
            $info_data['book_info']=$book_info['longIntro'];
            $info_data['book_words_number']=$book_info['wordCount'];
            $info_data['chapter_number']=$book_info['chaptersCount'];
            $info_data['chapter_new_name']=$book_info['lastChapter'];
            $info_data['book_update_time']=time();
            $info_data['book_score']=!empty($book_info['rating']['score'])?$book_info['rating']['score']:0;
            return $info_data;
        }else{
            return false;
        }
    }
}
