<?php
	class Printer{
		private $printPlay;

		function __construct(){
			$this->printPlay = "";
		}

		private function init(){
			$this->printPlay = "";
		}

		public function printPit($PicherName){
			$this->printPlay = $this->printPlay."<br>투수 : ".$PicherName."</br>";
		}

		public function printHit($HitterNum,$HitterName){
			$this->printPlay = $this->printPlay."<br>".($HitterNum + 1) ."번 타자 : ".$HitterName."</br>";
		}

		public function printBallType($inningBallCount, $type){
			$this->printPlay = $this->printPlay."-".$inningBallCount."구 : ".$type."</br>";
		}
		public function printResult($HitterName,$translate){
			$this->printPlay = $this->printPlay.$HitterName.": $translate</br>";
		}

		public function printBaseState($beforeBase,$HitterName,$afterBase){
			$this->printPlay = $this->printPlay.$beforeBase."루 주차 " .$HitterName. " : ";
				if($afterBase > 3)
					$this->printPlay = $this->printPlay."홈인</br>";
				else
					$this->printPlay = $this->printPlay.$afterBase."루까지 진루</br>";
				
		}

		public function getPrintPlay(){
			$printPlay = $this->printPlay;
			$this->init();
			return $printPlay;
		}
	}
?>