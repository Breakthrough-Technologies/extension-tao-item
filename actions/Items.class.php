<?php

class Items extends Module{

	public function index(){
		$context = Context::getInstance();
		$this->setData('testVar', "this is the ". get_class($this) ." module, " . $context->getActionName());
		$this->setView('view.tpl');
	}
	
	public function create(){
		$context = Context::getInstance();
		$this->setData('testVar', "this is the ". get_class($this) ." module, " . $context->getActionName());
		$this->setView('view.tpl');;
	}
	
	public function import(){
		$context = Context::getInstance();
		$this->setData('testVar', "this is the ". get_class($this) ." module, " . $context->getActionName());
		$this->setView('view.tpl');
	}
	
	public function select(){
		$context = Context::getInstance();
		$this->setData('testVar', "this is the ". get_class($this) ." module, " . $context->getActionName());
		$this->setView('view.tpl');
	}
	
	public function search(){
		$context = Context::getInstance();
		$this->setData('testVar', "this is the ". get_class($this) ." module, " . $context->getActionName());
		$this->setView('view.tpl');
	}
}
?>