<?php
	class status{
		
		private $stat;
		
		public function __construct($_stat){
			$this->stat = $_stat;
		}
		public function get_stat(){
			return $this->stat;
		}
	}
?>