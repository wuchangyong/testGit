<?php
namespace Home\Model;

use Think\Model;
class TbUserModel extends Model{
    
    public function loadUserByName($userName) {
        return $this->where("userName='%s'",array($userName))->find();
    }
}
?>