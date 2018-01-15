<?php
	class priority{
		private $pri = '';
	
		public function __construct($_pri){
			$this->pri = $_pri;
		}
		public function get_pri(){
			return $this->pri;
		}
	}
?>