<?php
namespace Common\Util;

/**
 * @notes       : 验证类，用户处理验证数据
 * @author      : gary.Lee<321539047@qq.com>
 * @create time : 2020-01-10 11:43
 * @details     :
 * @package Common\Util
 */
class GValidate
{
    /**
     * @var string 验证后的错误
     */
    private $errorMsg = '';
    /**
     * 验证规则
     * @var array ['name'=>'require|max:25']
     */
    private $rules = [];
    /**
     * 验证规则错误提示
     * @var array ['name.require'=>'名称必须输入']
     */
    private $ruleErrors = [];
    private $isOk = true;

    public function __construct($rules=[],$rules_err=[])
    {
        $this->rules = $rules;
        $this->ruleErrors = $rules_err;
    }

    public function setRules($rules=[],$rules_err=[]){
        if(!empty($rules)){
            $this->rules = array_merge($this->rules,$rules);
        }

        if(!empty($rules_err)){
            $this->ruleErrors = array_merge($this->ruleErrors,$rules_err);
        }
    }

    public function check($validate_data=false){
        $data = $validate_data ? $validate_data : $_POST;
        $this->isOk = true;
        foreach ($this->rules as $key=>$rules){
            $rules = explode('|',$rules);
            foreach ($rules as $rule){
                switch ($rule){
                    case 'require'://验证是否为空
                    case 'empty'://验证是否为空
                        if(empty($data[$key])){
                            $this->setRuleError($key,$rule);
                            break 3;
                        }
                        break;
                    case 'number'://验证数字
                        if(!empty($data[$key]) && !is_numeric($data[$key])){
                            $this->setRuleError($key,$rule);
                            break 3;
                        }
                        break;
                    case 'phone'://验证电话
                        if(!empty($data[$key]) && !preg_match('/^1\d{10}$/',$data[$key],$matches)){
                            $this->setRuleError($key,$rule);
                            break 3;
                        }
                        break;
                    case 'date'://验证时间
                        if(!empty($data[$key]) && strtotime('1980-01-01 00:00:00') > strtotime($data[$key])){
                            $this->setRuleError($key,$rule);
                            break 3;
                        }
                        break;
                    case (strpos($rule,'max') !== false) : //验证最大值max:10
                        $max_len = substr($rule,4);
                        if(!empty($data[$key]) && strlen($data[$key]) > $max_len){
                            $this->setRuleError($key,'max');
                            break 3;
                        }
                        break;
                    case (strpos($rule,'min') !== false) ://验证最小值min:10
                        $min_len = substr($rule,4);
                        if(!empty($data[$key]) && strlen($data[$key]) < $min_len){
                            $this->setRuleError($key,'min');
                            break 3;
                        }
                        break;
                    case (strpos($rule,'in') !== false) : //验证包含in[1,2,3]
                        if(empty($data[$key])){
                            $this->setRuleError($key,'in');
                            break 3;
                        }
                        $str = str_replace(['[',']'],'',substr($rule,2));
                        $str = (array)explode(',',$str);
                        if(!in_array($data[$key],$str)){
                            $this->setRuleError($key,'in');
                            break 3;
                        }
                        break;
                }
            }
        }
        return $this->isOk;
    }


    public function getError(){
        return $this->errorMsg;
    }

    private function setRuleError($name,$rule){
        $this->isOk = false;
        $key = $name.'.'.$rule;
        $this->errorMsg = isset($this->ruleErrors[$key]) ? $this->ruleErrors[$key] : '';
    }
}