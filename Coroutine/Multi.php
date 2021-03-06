<?php
namespace Coroutine;

class Multi extends Task{

	protected $_callList = array();

	protected $_callRsp = array();

	const TASK_QUEUE = "multi";

	public function wrap($coroutine){
		$this->_callList[] = $coroutine;
		return \Coroutine::wrap($this->multiCoroutine($coroutine));
	}

	public function multiCoroutine($coroutine){
		try{
			$resp = yield from $coroutine;
			$this->_callRsp[] = $resp;
			if(count($this->_callRsp) == count($this->_callList)){
				$this->executeCoroutine($this->_callRsp);
				$this->next();
			}
		}catch(\Exception $e){
			$this->executeCoroutine(null,$e);
			$this->next();
		}
	}
}