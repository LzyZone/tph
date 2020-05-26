<?php
namespace Org\Util\Wechat;
use Think\Log;

/**
 * @todo 微信支付
 * @author gary.li<1031965173@qq.com>
 * @date 2018-10-23
 */
class Pay{
    const PAY_URL_PREFIX = "https://api.mch.weixin.qq.com/";
    public static function sendredpack($openid,$totalAmount,$count=1){
        $config = \Org\Util\Tools\UtilConfig::getDtaConfig('wechat');
        $id = intval(I('get.id'));
        $config = $config[$id];
        $url = self::PAY_URL_PREFIX."mmpaymkttransfers/sendredpack";
        $param = array(
            'nonce_str'  => self::getNonceStr(),
            'mch_billno' => self::makeOrderSn(),
            'mch_id'    => $config['mchid'],
            'wxappid'   => $config['w_appid'],
            'send_name' => $config['w_name'],
            're_openid' => $openid,
            'total_amount' => $totalAmount, //付款金额，单位分
            'total_num' => $count,
            'wishing'   => $config['wishing'],
            'client_ip' => get_client_ip(),
            //'scene_id'  => 'PRODUCT_2',
            'act_name'  => $config['act_name'],
            'remark'    => $config['remark']
        );

        if($config['scene_id']){
            $param['scene_id'] = $config['scene_id'];
        }

        $param['sign'] = self::makeSign($param,$config['pay_key']);
        $postXml = self::ToXml($param);
        $response = \Org\Util\Wechat\Tools::postXmlCurl($url,$postXml);
        $result = self::FromXml($response);
        if(isset($result['return_code']) && isset($result['result_code'])
            && $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            return $result;
        }
        $result['post'] = $param;
        //记录错误
        \Think\Log::write("wechat_pay_error:".json_encode($result));
        throw new \Exception(json_encode($result),4000);
    }

    private static function makeSign($param,$key){
        //签名步骤一：按字典序排序参数
        ksort($param);
        $tempStr = '';
        foreach ($param as $k=>$v){
            if($v === ''){continue;}
            $tempStr .= "{$k}={$v}&";
        }

        //签名步骤二：在string后加入KEY
        $tempStr .= "key=".$key;
        //签名步骤三：MD5加密
        $sign = md5($tempStr);
        //签名步骤四：所有字符转为大写
        return strtoupper($sign);
    }


    /**
     * 输出xml字符
     * @throws \Exception
     **/
    public static function ToXml($param)
    {
        if(!is_array($param)
            || count($param) <= 0)
        {
            throw new \Exception("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($param as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @throws \Exception
     */
    public static function FromXml($xml)
    {
        if(!$xml){
            throw new \Exception("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $param = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $param;
    }


    public static function makeOrderSn(){
        list($usec, $sec) = explode(" ", microtime());
        $msec = round($usec*1000);
        $maxLen = 28;
        $str = date('YmdHis',$sec).str_pad($msec,3,'0',STR_PAD_RIGHT);
        $ldStrLen = $maxLen-strlen($str);
        if($ldStrLen > 0){
            $numbers = [0,1,2,3,4,5,6,7,8,9];
            for ($i=0;$i<$ldStrLen;$i++){
                $str .= $numbers[mt_rand(0,9)];
            }
        }
        return $str;
    }

    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

}