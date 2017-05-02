<?php
session_start();
// if(!isset($_COOKIE["userName"]) || $_COOKIE["userName"] == ""){
//     header("location:".ROOT."part9/login.php?".http_build_query(array("请先登录!")));
// }
?>
<html>
	<head>
		<title>欢迎</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="Public/easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="Public/easyui/themes/icon.css">
		<script type="text/javascript" src="Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<style type="text/css">
        .calendarShow{display:block;width:176px;height:54px;padding-top:30px;border-radius:5px;}
		.calendarShow span{font-weight:normal;opacity:0.3;}
        </style>
		<script type="text/javascript">
		function addTabs(title, url){
			var b = $("#tt").tabs("exists", title);
			if(b){
				$("#tt").tabs("select", title);
				$('#tt').tabs('update', {
					tab: $("#tt").tabs("getTab", title),
					options:{}
				});
			}else{
				$('#tt').tabs('add',{
					title: title,
					selected: true,
					closable: true,
					content:'<iframe src="'+url+'" width="100%" height="100%" frameborder="0" scrolling="auto"></iframe>'
				});
			}
		}
		$(function(){
			$("#calendar").calendar({
				formatter: function(date){
					return "<a class='calendarShow' title='点击查看当天日程'>"
					+date.getDate()+"<br/><span>点击查看</span></a>";
				},
				onSelect: function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					addTabs("日程"+y+"-"+m+"-"+d,"scheduleList.php?searchDate="+y+"-"+m+"-"+d);

				} 
			});
		});
		</script>
	</head>
	<body class="easyui-layout">   
        <div data-options="region:'north',split:false,collapsible:false" style="height:50px;">
        	欢迎你，<?php echo $_SESSION["loginUser"]["truename"];?>
        </div>   
        <div data-options="region:'west',title:'系统菜单',split:true" style="width:200px;">
        	<ul class="easyui-tree"> 
        		<?php 
        		foreach ($_SESSION["menus"] as $m2){
        		    if($m2["level"] == 2){
        		        echo "<li>";
        		        echo "<span>{$m2["name"]}</span>";
        		        echo "<ul>";
        		        foreach ($_SESSION["menus"] as $m3){
        		            if($m3["level"] == 3 && $m3["parentid"] == $m2["mid"]){
        		                echo "<li><a href='javascript:addTabs(\"{$m3["name"]}\",\"{$m3["url"]}\");'>{$m3["name"]}</a></li>";
        		            }
        		        }
        		        echo "</ul>";
        		    }
        		}
        		?>  
            </ul> 
        </div>   
        <div data-options="region:'center'" style="background:#eee;">
        	<div id="tt" class="easyui-tabs" data-options="fit:true">   
                <div title="欢迎界面" style="width:99%;margin:auto;height:99%">
					<div class="easyui-calendar" id="calendar" data-options="fit:true" style="padding:5px; height:100%;width: auto"></div>
				</div>
            </div>  
        </div>   
    </body> 
</html>