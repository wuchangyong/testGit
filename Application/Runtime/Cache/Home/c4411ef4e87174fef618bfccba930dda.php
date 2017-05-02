<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>欢迎</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="<?php echo ($BASEPATH); ?>Public/easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="<?php echo ($BASEPATH); ?>Public/easyui/themes/icon.css">
		<script type="text/javascript" src="<?php echo ($BASEPATH); ?>Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="<?php echo ($BASEPATH); ?>Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="<?php echo ($BASEPATH); ?>Public/easyui/locale/easyui-lang-zh_CN.js"></script>
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
        	欢迎你，<?php echo ($_SESSION['loginUser']['truename']); ?>
        </div>   
        <div data-options="region:'west',title:'系统菜单',split:true" style="width:200px;">
        	<ul class="easyui-tree"> 
        	    <?php if(is_array($_SESSION['menus'])): foreach($_SESSION['menus'] as $key=>$m1): if(($m1["level"]) == "2"): ?><li>
        		        	<span><?php echo ($m1["name"]); ?></span>
        		            <ul>
        		            	<?php $mid = $m1["mid"]; ?>
        		                <?php if(is_array($_SESSION['menus'])): foreach($_SESSION['menus'] as $key=>$m2): if($m2["level"] == 3 AND $m2["parentid"] == $mid): ?><li><a href="javascript:addTabs('<?php echo ($m2["name"]); ?>','<?php echo ($BASEPATH); echo ($m2["url"]); ?>');"><?php echo ($m2["name"]); ?></a></li><?php endif; endforeach; endif; ?>
        		            </ul>     
        		        </li><?php endif; endforeach; endif; ?>
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