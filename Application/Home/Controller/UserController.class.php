<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
use Home\Model\TbUserModel;
use Think\Upload;
class UserController extends Controller{
    
    private $userModel;
    public function __construct(){
        parent::__construct();
        $this->userModel = M("tb_user");//D("TbUser") new TbUserModel()
        //M("tb_user")//new Model("tb_user");
    }
    
    public function login($userName, $userPass){
//         $userName = $_POST["userName"];
//         $userPass = $_POST["userPass"];
        //echo "$userName, $userPass";
        //$this->success("登录成功","http://localhost:8080/tp/login.php",5);
//         $this->error("登录失败-用户名不存在！");
        //查询数据
        $query = new \stdClass();
        $query->userName = $userName;
        $users = $this->userModel->where($query)->select();
        if(count($users) > 0){
            $u = $users[0];
            if($userPass == $u["userpass"]){
                $_SESSION["loginUser"] = $u;
                
                //查询用户拥有的菜单
                $menus = $this->userModel->table("tb_userjob uj,tb_jobmenu jm,tb_menu m")
                ->field("m.*")
                ->where("uj.jid=jm.jid and jm.mid=m.mid and uj.uid=".$u["uid"])
                ->select();
                $_SESSION["menus"] = $menus;
                //密码正确
                //redirect(BASEPATH."easyuiTest.php");
                //header("location:".BASEPATH."easyuiTest.php");
                $this->assign("BASEPATH",BASEPATH);
                $this->display("easyuiTest");
            }else{
                //密码错误
                $_SESSION["loginError"] = "密码错误";
                redirect(BASEPATH."login.php");
                //$this->error("密码错误!");
                //header("location:".BASEPATH."login.php");
            }
        }else{
            //用户名不存在
            $_SESSION["loginError"] = "用户名不存在";
            redirect(BASEPATH."login.php");
            //$this->error("用户名不存在!");
            //header("location:".BASEPATH."login.php");
        }
    }
    
    /**
     * 同步+bootstrap加载用户列表并且分页
     * @param number $pageNo
     * @param number $pageSize
     * @param unknown $searchPhone
     * @param unknown $searchName
     */
    public function loadUserListByPage($pageNo=1, $pageSize=10, $searchPhone=null, $searchName=null){
        $query = array();
        if($searchPhone != null && $searchPhone != ""){
            //$query .= "and userName like '%$searchPhone%'";
            $query["userName"] = array("LIKE","%$searchPhone%");
        }
        if($searchName != null && $searchName != ""){
            //$query .= "and trueName like '%$searchName%'";
            $query["trueName"] = array("LIKE","%$searchName%");
        }
        //总数量
        $total = $this->userModel->where($query)->count();
        //当前这一页的数据
        $rows = $this->userModel->where($query)->order("uid desc")->page($pageNo,$pageSize)->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->assign("page",$page);
        $this->assign("BASEPATH",BASEPATH);
        $this->display("loadUserListByPage");
    }
    
    /**
     * 异步+easyui的datagrid加载用户列表并且分页
     * @param number $pageNo
     * @param number $pageSize
     * @param unknown $searchPhone
     * @param unknown $searchName
     */
    public function loadUserList($pageNo=1, $pageSize=10, $searchPhone=null, $searchName=null){
        $query = array();
        if($searchPhone != null && $searchPhone != ""){
            //$query .= "and userName like '%$searchPhone%'";
            $query["userName"] = array("LIKE","%$searchPhone%");
        }
        if($searchName != null && $searchName != ""){
            //$query .= "and trueName like '%$searchName%'";
            $query["trueName"] = array("LIKE","%$searchName%");
        }
        //总数量
        $total = $this->userModel->where($query)->count();
        //当前这一页的数据
        $rows = $this->userModel->where($query)->order("uid desc")->page($pageNo,$pageSize)->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->ajaxReturn($page);
    }
    
    /**
     * 异步提交-新增或编辑用户
     */
    public function saveOrUpdateUser() {
        $data = $this->userModel->create();
        if($data["uid"] < 0){
            $this->userModel->field("userName,userPass,trueName")
            ->add();
        }else{
            $this->userModel->field("userName,userPass,trueName")
            ->where("uid=%d",$data["uid"])->save();
        }
        $this->loadUserList();
    }
    
    
    public function testView(){
        //
        $this->assign("empty","<span style='color:red;'>对不起，暂时未找到你想要的数据...</span>");
        $this->assign("aaa",array("中国","美国","英国","乌拉圭","巴拉圭","巴西","阿根廷"));
        $this->display();
    }
    
    /**
     * 同步提交-新增或修改用户
     */
    public function saveOrUpdateUser2(){
        $data = $this->userModel->create();
        if($data["uid"] < 0){
            $this->userModel->field("userName,userPass,trueName")
            ->add();
        }else{
            $this->userModel->field("userName,userPass,trueName")
            ->where("uid=%d",$data["uid"])->save();
        }
        $this->loadUserListByPage();
    }
    
    /**
     * 通过uid异步加载用户
     * @param int $uid
     */
    public function loadUserById($uid){
        $user = $this->userModel->find($uid);
        $this->ajaxReturn($user);
    }
    
    /**
     * 同步提交-文件上传
     */
    public function testFileUpload(){
        $config = array(
            "maxSize"=>0,
            "rootPath"=>"./Public/upload/",
            "savePath"=>"",
            "saveName"=>rand(0,10000)."".time(),
            "exts"=>array("jpg","png","gif","jpeg")
        );
        $up = new Upload($config);
        $info = $up->uploadOne($_FILES["file"]);
        if(!$info){
            echo $up->getError();
        }else{
            print_r($info);
        }
    }
    
}

?>