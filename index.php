<?php
/**
 * Created by PhpStorm.
 * User: VicChan
 * Date: 5/28/16
 * Time: 9:40 AM
 */

header('Content-type:text/html;charset=utf-8');
include_once ("simple_html_dom.php");

class Crawer {

    var $base_url;
    var $htmlReponse;
    var $response;

    public function get_movie_comment($movieId) {
        $url = "https://movie.douban.com/subject/".$movieId;
        $this->base_url = $url;
        $this->start_crawl($url);
    }

    public function sendResponse() {
        print_r($this->response);
    }

    private function start_crawl($url) {
        $html = file_get_html($url);

       $result = array();

        $i = 0;
        while($i < 5) {

            $time = $html->find('div[class=review-hd-info]',$i)->childNodes(0);

            $review = $html->find('div[class=review-short]',$i)->childNodes(0);

            $i ++;

            $name = strip_tags($time);
            $content = strip_tags($review);
            $info['name'] = $name;
            $info['content'] = $content;
            $result[$i] = $info;

        }
        if(!$result) {
            echo 'wrong';
            exit();
        }
        print_r($result);
        $this->response = $result;

        $this->sendResponse();
    }

}


$crawler = new Crawer();

$crawler->get_movie_comment('26282530');


?>