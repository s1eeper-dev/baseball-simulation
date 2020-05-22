<?php
	class BaseballQueue{
		const BASE = 5;
		
		private $printer;

		private $Queue; 
		private $State;
		
		private $inningScore;

		function __construct($printer){
			$this->Queue = array(array(base, hName));
			$this->State = array(front, rear);
			
			$this->printer = $printer;
		}
		
		public function init(){
			for($i = 0; $i < self::BASE; $i++)
				$this->Queue[$i][base] = 0;

			$this->State[front] = $this->State[rear] = 0;
			$this->inningScore = 0;
		}
		
		private function error($String){
			echo $String;
		}
		
		private function is_empty(){
			return ($this->State[front] == $this->State[rear]);
		}
		
		private function is_full(){
			return (($this->State[rear]+1) % self::BASE == $this->State[front]);
		}
		
		public function enQueue($base,$hName){
			if($this->is_full())
				error("Queue is fully\n");
			
			$this->State[rear] = ($this->State[rear] + 1) % self::BASE;
			$this->Queue[$this->State[rear]][base] = $base;
			$this->Queue[$this->State[rear]][hName] = $hName;
		
			$this->update($base);
		}
		
		public function deQueue(){
			if($this->is_empty())
				error("Queue is empty\n");
			
			$this->State[front] = ($this->State[front] + 1) % self::BASE;

			$this->inningScore++;
		}
		
		private function update($base){
			for($i = ($this->State[rear] + 1) % self::BASE; $i != $this->State[rear]; $i = ($i + 1 ) % self::BASE){
				if($this->Queue[$i][base] > 0){
					$beforeBase = $this->Queue[$i][base];				
					
					$this->Queue[$i][base] = $this->Queue[$i][base] + $base;
					$afterBase = $this->Queue[$i][base];
				
					$this->printer->printBaseState($beforeBase,$this->Queue[$i][hName],$afterBase);
				}	
			}
			for($i = 0; $i < self::BASE; $i++){
				if($this->Queue[$i][base] > 3){
					$this->Queue[$i][base] = 0;
					$this->dequeue();
				}
			}
		}

		public function getInningScore(){
			return $this->inningScore;
		}
		
	}

?>