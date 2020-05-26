<?php
namespace Common\Util;

use Org\Util\Wechat\Wechat;
use Think\Log;

class WechatServer extends Wechat
{
    public function __construct()
    {
        $config = C('WX_CONFIG');
        $options = array(
            'appid'     => $config['appid'],
            'appsecret' => $config['appsecret'],
        );
        parent::__construct($options);
    }

    /**
     * 发货通知
     * @param $openid
     * @param $order_no
     * @param $eps_name
     * @param $eps_no
     * @return array|bool
     */
    public function sendDeliverMsg($openid,$order_no,$eps_name,$eps_no,$remark=null,$url=null){
        $templateId = 'Eua7QrVsCKm7H_YHCbAXMK3ZdTGaC9-Hml7A-_fRFjw';
        $remark = $remark != null ?$remark : '可通过订单号查看物流信息，感谢您的惠顾！';
        $url = $url != null ? $url : 'https://www.sf-express.com/cn/sc/';
        $data = [
            'touser' => $openid,
            'template_id' => $templateId,
            'url' => $url,
            'topcolor' => '',
            'data' => [
                'first'    => ['value'=>'您好，您购买的商品已发货'],
                'keyword1' => ['value'=>$order_no],
                'keyword2' => ['value'=>$order_no],
                'keyword3' => ['value'=>$eps_name],
                'keyword4' => ['value'=>$eps_no],
                'remark'   => ['value'=>$remark],
            ]
        ];
        $response = $this->sendTemplateMessage($data);
        if(!$response){
            Log::write("err-msg:{$this->errMsg},err-code:{$this->errCode}");
            Log::write('微信消息发送失败，原因:'.$response);
            Log::write(json_encode($data));
        }
        return $response;
    }

    /**
     * 发送用户订单通知
     * @param $openid
     * @param $product_name
     * @param $order_no
     * @param $amount
     * @param null $remark
     * @param null $url
     * @return array|bool
     */
    public function sendUserOrderMsg($openid,$product_name,$order_no,$amount,$remark=null,$url=null){
        $templateId = '7dMP_RIZN_tb5miL7EsGhAZOXuDXJMO7bn8BPEhlr3I';
        $remark = $remark != null ? $remark : '';
        $url = $url != null ? $url : '';
        $data = [
            'touser' => $openid,
            'template_id' => $templateId,
            'url' => $url,
            'topcolor' => '',
            'data' => [
                'first'    => ['value'=>'尊敬的客户，您的订单已经支付成功'],
                'keyword1' => ['value'=>$product_name],
                'keyword2' => ['value'=>$order_no],
                'keyword3' => ['value'=>$amount],
                'keyword4' => ['value'=>date('Y-m-d H:i:s')],
                'remark'   => ['value'=>$remark],
            ]
        ];
        $response = $this->sendTemplateMessage($data);
        if(!$response){
            Log::write("err-msg:{$this->errMsg},err-code:{$this->errCode}");
            Log::write('sendUserOrderMsg-微信消息发送失败，原因:'.$response);
            Log::write(json_encode($data));
        }
        return $response;
    }

    /**
     * 发送订单通知给管理员
     * @param $openid
     * @param $product_name
     * @param $order_no
     * @param $amount
     * @param null $remark
     * @param null $url
     * @return array|bool
     */
    public function sendAdminOrderMsg($openid,$product_name,$order_no,$amount,$remark=null,$url=null){
        $templateId = '7dMP_RIZN_tb5miL7EsGhAZOXuDXJMO7bn8BPEhlr3I';
        $remark = $remark != null ?$remark : '';
        $url = $url != null ? $url : '';
        $data = [
            'touser' => $openid,
            'template_id' => $templateId,
            'url' => $url,
            'topcolor' => '',
            'data' => [
                'first'    => ['value'=>'商城有新的订单，请到后台进行发货'],
                'keyword1' => ['value'=>$product_name],
                'keyword2' => ['value'=>$order_no],
                'keyword3' => ['value'=>$amount],
                'keyword4' => ['value'=>date('Y-m-d H:i:s')],
                'remark'   => ['value'=>$remark],
            ]
        ];
        $response = $this->sendTemplateMessage($data);
        if(!$response){
            Log::write('sendAdminOrderMsg-微信消息发送失败，原因:'.$response);
            Log::write("err-msg:{$this->errMsg},err-code:{$this->errCode}");
            Log::write(json_encode($data));
        }
        return $response;
    }

    /**
     * 发送保单信息
     * @param $openid 微信用户openid
     * @param $applicant 投保人
     * @param $id_card 投保人身份证
     * @param $appl_no 头保单号
     * @param null $remark 备注
     * @param null $url
     * @return array|bool
     */
    public function sendApplMsg($openid,$applicant,$id_card,$appl_no,$remark=null,$url=null){
        $templateId = 'heiXMZ_kpHBi1mCL042vx_cCCOqUcfLKWqSM-lHFu7A';
        $remark = $remark != null ? $remark : '具体内容以国寿女性安康团体疾病保险条款为准';
        $url = $url != null ? $url : '';
        $data = [
            'touser' => $openid,
            'template_id' => $templateId,
            'url' => $url,
            'topcolor' => '',
            'data' => [
                'first'    => ['value'=>'国寿女性安康团体疾病保险保单如下'],
                'keyword1' => ['value'=>$applicant],
                'keyword2' => ['value'=>$id_card],
                'keyword3' => ['value'=>$appl_no],
                'keyword4' => ['value'=>date('Y-m-d H:i:s')],
                'remark'   => ['value'=>$remark],
            ]
        ];
        $response = $this->sendTemplateMessage($data);
        if(!$response){
            Log::write("err-msg:{$this->errMsg},err-code:{$this->errCode}");
            Log::write('sendApplMsg-微信消息发送失败，原因:'.$response);
            Log::write(json_encode($data));
        }
        return $response;
    }

    /**
     * 发送预约通知
     * @param $openid
     * @param $user_name 预约者姓名
     * @param $item_name 预约项目
     * @param $appo_date 预约时间
     * @param null $remark
     * @param null $url
     * @return array|bool
     */
    public function sendAppoMsg($openid,$user_name,$item_name,$appo_date,$remark=null,$url=null){
        $templateId = 'yKLwh7bhohswJYUi-G1kcU0urw_wMUYHF4Vb1uUiB7U';
        $url = $url != null ? $url : '';
        $data = [
            'touser' => $openid,
            'template_id' => $templateId,
            'url' => $url,
            'topcolor' => '',
            'data' => [
                'first'    => ['value'=>'预约通知'],
                'keyword1' => ['value'=>$user_name],
                'keyword2' => ['value'=>$item_name],
                'keyword3' => ['value'=>$appo_date],
                'keyword4' => ['value'=>'待确认'],
                'remark'   => ['value'=>'请尽快处理！'],
            ]
        ];
        $response = $this->sendTemplateMessage($data);
        if(!$response){
            Log::write("err-msg:{$this->errMsg},err-code:{$this->errCode}");
            Log::write('sendApplMsg-微信消息发送失败，原因:'.$response);
            Log::write(json_encode($data));
        }
        return $response;
    }




}