<?php
function x_isset($data,$key,$default=''){
    return isset($data[$key]) ? $data[$key] : $default;
}

function image_src($src){
    if(strpos($src,'http') !== false){
        return $src;
    }elseif($src){
        return "/Uploads/{$src}";
    }else{
        return C('DEFAULT_MEMBER_HEADPIC');
    }
}