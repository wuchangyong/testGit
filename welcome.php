<?php
require_once '../autoload.php';
session_start();
// if(!isset($_COOKIE["userName"]) || $_COOKIE["userName"] == ""){
//     header("location:".ROOT."part9/login.php?".http_build_query(array("请先登录!")));
// }
?>
<html>
	<head>
		<title>欢迎</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="<?php echo ROOT;?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo ROOT;?>bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="<?php echo ROOT;?>bootstrap/js/bootstrap.min.js"></script>
		<style type="text/css">
        li li:hover{background-color:silver;}
        </style>
		<script type="text/javascript">
		$(function(){
			$(".m1").click(function(){
				if($(this).attr("aa") == 0){
					$(this).parent().find("ul").show(300);
					$(this).attr("aa", 1);
				}else{
					$(this).parent().find("ul").hide(300);
					$(this).attr("aa", 0);
				}
			});
		});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="row" style="height:100px;padding-top:10px;border:1px solid blue;">
    			<div class="col-md-12">
    				<img src="<?php echo ROOT.$_SESSION["loginUser"][4];?>" style="height:98px;margin-top:-10px;margin-left:-15px;">
    				<b>欢迎你，<?php echo $_SESSION["loginUser"][3];?></b>
    				<a href="login.php">退出</a>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-md-2" style="border:1px solid blue;height:550px;">
    				<ul style="list-style: none;margin-left:-35px;">
    					<?php 
    					foreach($_SESSION["menus"] as $m){
    					    if($m[3] == 2){
    					        echo "<li>";
    						    echo     "<span class='m1' aa='0' style='cursor:pointer;'>$m[1]</span>";
    						    echo     "<ul style='display:none;'>";
    						    foreach($_SESSION["menus"] as $m3){
    						        if($m3[3] == 3 && $m3[4] == $m[0]){
    						            echo "<li><a href='$m3[2]' target='center'>$m3[1]</a></li>";
    						        }
    						    }
    						    echo     "</ul>";
    					        echo "</li>";
    					    }
    					}
    					?>
    				</ul>
    			</div>
    			<div class="col-md-10" style="border:1px solid blue;height:550px;">
    				<iframe name="center" height="100%" width="100%" frameborder="0"></iframe>
    			</div>
    		</div>
		</div>
	</body>
</html>