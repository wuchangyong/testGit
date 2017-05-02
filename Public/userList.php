<?php 
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>用户列表</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="easyui/themes/icon.css">
		<script type="text/javascript" src="bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="easyui/locale/easyui-lang-zh_CN.js"></script>
		<style type="text/css">
        #ff input{
	        width:250px;border:1px solid green;height:25px;
        	border-radius:4px;
        }
        #ff tr{height:40px;}
        </style>
		<script type="text/javascript">
		$(function(){
			$('#dg').datagrid({    
			    url:'../index.php/Home/User/loadUserList',   
			    striped:true,
			    pagination:true,
			    rownumbers:true,
			    frozenColumns:[[
					{field:'hfdhs',checkbox:true}
			    ]],
			    columns:[[    
			        {field:'uid',title:'编号',width:100,align:'center',hidden:true},    
			        {field:'username',title:'用户名',width:200,align:'center'},    
			        {field:'userpass',title:'密码',width:90,align:'center'}, 
			        {field:'truename',title:'姓名',width:200,align:'center',formatter:function(value,row,index){
						return "<b style='color:red;'>"+value+"</b>";
				    }},
			        {field:'picture',title:'头像图片',width:200,align:'center'}   
			    ]],
			    toolbar: "#tb"
			});
			var pager = $("#dg").datagrid("getPager");
			pager.pagination({
				onSelectPage:function(pageNumber, pageSize){
					$("#dg").datagrid('loading');
					$.post("../index.php/Home/User/loadUserList?pageNo="+pageNumber+"&pageSize="+pageSize,function(data){
						$("#dg").datagrid("loadData",{
							rows:data.rows,
							total:data.total
						});
						$("#dg").datagrid('loaded');
					},"json");
				}
			});
			$('#win').window('close');  // close a window
		});
		function openWindowForAdd(){
			$('#win').window('open');  // open a window
			$("#uid").val("-1");
		}
		function openWindowForEdit(){
			var rows = $("#dg").datagrid("getSelections");
			if(rows.length > 1){
				alert("对不起，你只能选中一行进行编辑！");
				return;
			}
			if(rows.length == 0){
				alert("对不起，请先选中一行进行编辑！");
				return;
			}
			var row = rows[0];
			//表单回填数据
			//$("#uid").val(row[0]);
			//$("#userName").val(row[1]);
			//$("#userPass").val(row[2]);
			//$("#trueName").val(row[3]);
			$('#ff').form('load',{
				uid:row.uid,
				userName:row.username,
				userPass:row.userpass,
				trueName:row.truename
			});
			$('#win').window('open');
		}
		function saveOrUpdateUser(){
			//$("#ff").serialize()
			$.post("../index.php/Home/User/saveOrUpdateUser",
			{
				"uid"	   : $("#uid").val(),
				"userName" : $("#userName").val(),
				"userPass" : $("#userPass").val(),
				"trueName" : $("#trueName").val()
			},function(data){
				$("#dg").datagrid('loading');
				$("#dg").datagrid("loadData",{
					rows:data.rows,
					total:data.total
				});
				$("#dg").datagrid('loaded');
				$('#win').window('close');  // close a window
			},"json");
		}
		function doSearch(){
			$("#dg").datagrid('loading');
			$.post("../index.php/Home/User/loadUserList",{
				searchPhone : $("#searchPhone").val(),
				searchName  : $("#searchName").val()
			},function(data){
				$("#dg").datagrid("loadData",{
					rows:data.rows,
					total:data.total
				});
				$("#dg").datagrid('loaded');
			},"json");
		}
		</script>
	</head>
	<body>
		<table id="dg"></table>
		<div id="tb">
			<form>
				<input type="text" placeholder="按手机号搜索" id="searchPhone">
				<input type="text" placeholder="按姓名搜索" id="searchName">
				<br/>
				<a href="javascript:openWindowForAdd();" class="easyui-linkbutton" data-options="iconCls:'icon-add2',plain:true">添加</a>
				<a href="javascript:openWindowForEdit();" class="easyui-linkbutton" data-options="iconCls:'icon-edit',plain:true">编辑</a>
				<a href="" class="easyui-linkbutton" data-options="iconCls:'icon-delete',plain:true">删除</a>
				<a href="" class="easyui-linkbutton" data-options="iconCls:'icon-export',plain:true">导出Excel</a>
				<a href="javascript:doSearch();" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true">搜索</a>
			</form>
		</div>
		<div id="win" class="easyui-window" title="新增/编辑用户" style="width:400px;height:220px;"   
        data-options="iconCls:'icon-add2',modal:true">   
			<form id="ff">
				<input type="hidden" name="uid" id="uid" value="">
				<table style="width:80%;margin:auto;" >
					<tr>
						<td><label>手机：</label></td>
						<td><input type="text" class="easyui-validatebox" id="userName" name="userName" placeholder="输入手机号"></td>
					</tr>
					<tr>
						<td><label>密码：</label></td>
						<td><input type="password" class="easyui-validatebox" id="userPass" name="userPass" placeholder="输入密码"></td>
					</tr>
					<tr>
						<td><label>姓名：</label></td>
						<td><input type="text" class="easyui-validatebox" id="trueName" name="trueName" placeholder="输入姓名"></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<a href="javascript:saveOrUpdateUser();" class="easyui-linkbutton" data-options="iconCls:'icon-add2'">确认</a> 
							<a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-undo'">取消</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>