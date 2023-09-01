<?php

namespace App\Http\Controllers;

use App\Models\Website;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as rs;


class WebsiteController extends Controller
{
    
    public function getWeb(){
        $websiteModel = new Website();
        $requestedUrl = rs::get("url");
        $checkWebsite = $websiteModel->checkWebsite($requestedUrl);
        if (count($checkWebsite) > 0){
            return json_encode( $checkWebsite );
        }
        $crawlRes = ( $this->crawl($requestedUrl,rs::get("depth")));
        $insertArr = array();
        foreach ($crawlRes as &$value) {
            $headers = get_headers($value);
            $statusCode = substr($headers[0], 9, 3);
            // ensure valid http response
            if ($statusCode == "200"){
                $tempInsert = ["originWebsite" => $requestedUrl , "URL" => $value ];
                // remove duplicates
                if (!in_array($tempInsert,$insertArr)){
                    $insertArr[] = $tempInsert;
                }
            }
        }
        $websiteModel->addWebsite($insertArr);
        return json_encode($websiteModel->checkWebsite($requestedUrl));
    }

    public function addWeb(Request $req){
        $websiteModel = new Website(); 
        $websiteModel->addWebsite($req->all());
    }
    public function crawl($url, $depth) {
        static $visited = array();
        $data = array();
    
        if ($depth === 0 || in_array($url, $visited)) {
            return $data;
        }
    
        $visited[] = $url;
    
        $html = file_get_contents($url);
        $dom = new DOMDocument;
        @$dom->loadHTML($html);
    
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $nextUrl = $link->getAttribute('href');
            if (strpos($nextUrl, 'http') !== false) {
                $data[] = $nextUrl;
                $data = array_merge($data, $this->crawl($nextUrl, $depth - 1));
            } elseif (strpos($nextUrl, '/') === 0) {
                $parsed = parse_url($url);
                $nextUrl = $parsed['scheme'] . '://' . $parsed['host'] . $nextUrl;
                $data[] = $nextUrl;
                $data = array_merge($data, $this->crawl($nextUrl, $depth - 1));
            }
        }
    
        return $data;
    }
}
