<?php
class BaseAction extends Action {
	public function _initialize(){
    	if(!isset($_SESSION['zs78_admin2'])){
    	_href(WEB_ROOT."index.php/Login");
    	return false;
   		}
   	}
	public function _empty(){
	    $this->redirect(WEB_ROOT);
	}
}
