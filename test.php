<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("TOKEN","doudoubao");//后台填写的token
$wechatObj = new wechatAPI();
$wechatObj->isValid();
class wechatAPI
{
public function isValid()//验证微信接口，如果确认是微信就返回它传来的echostr参数
{
 $echoStr = $_GET["echostr"];
 if ($this->checkSignature()) {
 echo $echoStr;
 exit;
 }
}
private function checkSignature() //官方的验证函数
{
 $signature = $_GET["signature"];
 $timestamp = $_GET["timestamp"];
 $nonce = $_GET["nonce"];
 $token = TOKEN;
 $tmpArr = array($token, $timestamp, $nonce);
 sort($tmpArr, SORT_STRING);
 $tmpStr = implode( $tmpArr );
 $tmpStr = sha1( $tmpStr );
 if( $tmpStr == $signature ){
 return true;
 }else{
 return false;
 }
}
};