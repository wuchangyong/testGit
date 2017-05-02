<?php
//应用配置
return array(
    'URL_PARAMS_BIND' => true,//开启请求参数绑定
    //'URL_PARAMS_BIND_TYPE'  =>  0,
	//'配置项'=>'配置值'
	"URL_ROUTER_ON"=>true,
    "URL_ROUTE_RULES"=>array(
        "aa/:id/:name"=>"Home/User/test"
    )
//     "URL_MAP_RULES"=>array(
//         //静态路由----简化URL作用
//         "bb"=>"Home/User/login"
//     )
);