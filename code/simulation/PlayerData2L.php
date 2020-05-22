<?php
	class PlayerData{
		
		private $q;
		private $printer;
		
		private $hitterNum;
		private $pitcherNum;
		
		private $h_Sqe;
		private $p_Sqe;

		private $pitcher; 
		private $hitter;
		
		private $outCount;
		private $ballCount;
		private $strikeCount;
		
		private $inningBallCount;
		private $totalBallCount;

		function __construct($printer, $q){
			$this->pitcher = array(array(PNAME,SO,BB,HBP));
			$this->hitter = array(array(HNAME,PA,AB,H,B2,B3,HR,GO,AO));
			$this->vs = array(array(array(PA,AB,H)));
			
			$this->printer= $printer;
			$this->q = $q;

			$this->hitterNum = 0;
			$this->pitcherNum = 0;

			$this->h_Sqe = -1;
			$this->p_Sqe = 0;
		}

		public function setPitcher($PNAME,$SO,$BB,$HBP){
			$this->pitcher[$this->pitcherNum][PNAME] = $PNAME;
			$this->pitcher[$this->pitcherNum][SO] = $SO;
			$this->pitcher[$this->pitcherNum][BB] = $BB;
			$this->pitcher[$this->pitcherNum][HBP] = $HBP;
			$this->pitcherNum++;
		}
		
		public function setHitter($HNAME,$PA,$AB,$H,$B2,$B3,$HR,$GO,$AO){
			$this->hitter[$this->hitterNum][HNAME] = $HNAME;
			$this->hitter[$this->hitterNum][PA] = $PA;
			$this->hitter[$this->hitterNum][AB] = $AB;
			$this->hitter[$this->hitterNum][H] = $H;
			$this->hitter[$this->hitterNum][B2] = $B2;
			$this->hitter[$this->hitterNum][B3] = $B3;
			$this->hitter[$this->hitterNum][HR] = $HR;
			$this->hitter[$this->hitterNum][GO] = $GO;
			$this->hitter[$this->hitterNum][AO] = $AO;
			$this->hitterNum++;
		}
			
		public function setVs($pitcherNum,$hitterNum,$PA,$AB,$H){
			$this->vs[$pitcherNum][$hitterNum][PA] = $PA;
			$this->vs[$pitcherNum][$hitterNum][AB] = $AB;
			$this->vs[$pitcherNum][$hitterNum][H] = $H;
		}

		private function batSwingRate($hitterNum){
			if($this->hitter[$hitterNum][AB] != 0 || $this->hitter[$hitterNum][PA] != 0 )
				return ($this->hitter[$hitterNum][AB]) / ($this->hitter[$hitterNum][PA] * 3);	
			else
				return 0.3;
			
		}		
		
		private function battingAverage($pitcherNum, $hitterNum){
			if($this->hitter[$hitterNum][AB] != 0 || $this->hitter[$hitterNum][PA] > 30)
				$hitterAvg = ($this->hitter[$hitterNum][H] / $this->hitter[$hitterNum][AB]);
			else
				$hitterAvg = 0.24;
			
			if($this->vs[$pitcherNum][$hitterNum][AB] != 0)
				$vsAvg = ($this->vs[$pitcherNum][$hitterNum][H] / $this->vs[$pitcherNum][$hitterNum][AB]);
			else
				$vsAvg = 0;

			$Avg;
			if($hitterAvg > $vsAvg)
				$Avg = $hitterAvg - (($hitterAvg - $vsAvg) * (1 / (30 - $this->vs[$pitcherNum][$hitterNum][PA])));
			else
				$Avg = $hitterAvg + (($vsAvg - $hitterAvg) * (1 / (30 - $this->vs[$pitcherNum][$hitterNum][PA])));

			return $Avg;
		}

		private function randFloat(){
			return mt_rand()/mt_getrandmax();
		}
		

		private function ballsRate($picterNum, $select){
			$SO = $this->pitcher[$picterNum][SO];
			$BB = $this->pitcher[$picterNum][BB];
			$HBP = $this->pitcher[$picterNum][HBP];
	
			if($SO == 0)
				$SO = 3;
			
			if($BB == 0)
				$BB = 2;
			
			if($HBP == 0)
				$HBP = 1;


			$totalBall = ($SO * 3) + ($BB * 4) + ($HBP);
			
			$ballRate = ($BB * 4) / $totalBall;
			$strikeRate = ($SO * 3) / $totalBall;
			$HBPRate = ($HBP) / $totalBall;

			switch($select){
				case "BALL":
					return $ballRate;
			
				case "STRIKE":
					return $ballRate + $strikeRate;
				
				case "HBP":
					return $ballRate + $strikeRate + $HBPRate;
				
				default:
					die("ballsRate() error");
					
			}
		}
		
		private function ballsTypes($picterNum){
			$rand = $this->randFloat();

			if($rand < $this->ballsRate($picterNum,"BALL"))
				return "BALL";

			else if($rand < $this->ballsRate($picterNum,"STRIKE"))
				return "STRIKE";

			else if($rand < $this->ballsRate($picterNum,"HBP"))
				return "HBP";

			else
				die("ballsTypes() error");
		}

		private function hitRate($hitterNum, $select){
			$H = $this->hitter[$hitterNum][H];
			$B2 = $this->hitter[$hitterNum][B2];
			$B3 = $this->hitter[$hitterNum][B3];
			$HR = $this->hitter[$hitterNum][HR];

			if($H < 50)
				$H = 50;

			if($B2 == 0){
				$B2 = 3;
				$H = $H + $B2;
			}

			if($B3 == 0){
				$B3 = 1;
				$H = $H + $B3;
			}

			if($HR == 0){
				$HR = 1;
				$H = $H + $HR;
			}

			

			$B1 = $H - ($B2 + $B3 + $HR);
			

			$B1Rate = $B1 / $H;
			$B2Rate = $B2 / $H;
			$B3Rate = $B3 / $H;
			$HRRate = $HR / $H;

			switch($select){
				case "B1":
					return $B1Rate;
			
				case "B2":
					return $B1Rate+$B2Rate;
				
				case "B3":
					return $B1Rate+$B2Rate+$B3Rate;
				
				case "HR":
					return $B1Rate+$B2Rate+$B3Rate+$HRRate;
				
				default:
					die("hitRate() error");

			}
		}

		private function hitTypes($hitterNum){
			$rand = $this->randFloat();

			if($rand < $this->hitRate($hitterNum,"B1"))
				return "B1";

			elseif($rand < $this->hitRate($hitterNum,"B2"))
				return "B2";

			elseif($rand < $this->hitRate($hitterNum,"B3"))
				return "B3";

			elseif($rand < $this->hitRate($hitterNum,"HR"))
				return "HR";

			else
				die("hitTypes() error");		
		}

		private function nonHitRate($hitterNum, $select){
			$GO = $this->hitter[$hitterNum][GO];
			$AO = $this->hitter[$hitterNum][AO];
			$AB = $this->hitter[$hitterNum][AB];
	
			
			if($GO == 0)
				$GO = 1;
			
			if($AO == 0)
				$AO = 1;

			if($this->hitter[$hitterNum][AB] !=0){
				$GoRate = $GO / $AB;
				$AoRate = $AO / $AB;
			}
			else
				$GoRate = $AoRate = 0.3;
			
		
			$foul = (1 - ($GoRate + $AoRate)) / 2;
			$swing = $foul;

			switch($select){
				case "GO":
					return $GoRate;
			
				case "AO":
					return $GoRate+$AoRate;
				
				case "foul":
					return $GoRate+$AoRate+$foul;

				case "swing":
					return $GoRate+$AoRate+$foul+$swing;
	
				default :
					die("nonHitRate() error");
			}
		}

		private function nonHitTypes($hitterNum){
			$rand = $this->randFloat();

			if($rand < $this->nonHitRate($hitterNum, "GO"))
				return "GO";

			elseif($rand < $this->nonHitRate($hitterNum, "AO"))
				return "AO";

			elseif($rand < $this->nonHitRate($hitterNum, "foul"))
				return "foul";

			elseif($rand < $this->nonHitRate($hitterNum, "swing"))
				return "swing";

			else
				die("nonHitTypes() error");
		}

		private function countBall($HitterName){
			if($this->ballCount == 4)
				return "BB";
			elseif($this->strikeCount == 3)
				return "SO";
			else
				return "continue";
		}

		private function result($HitterName,$val){
			switch($val){
					case "B1": 
						$this->q->enqueue(1,$HitterName);
						break;
					case "B2":
						$this->q->enqueue(2,$HitterName);
						break;
					case "B3":
						$this->q->enqueue(3,$HitterName);
						break;
					case "HR":
						$this->q->enqueue(4,$HitterName);
						break;
					case "GO":
						$this->outCount++;
						break;
					case "AO":
						$this->outCount++;
						break;
					case "foul":
						if($this->strikeCount != 2)
							$this->strikeCount++;
						break;
					case "swing":
						$this->strikeCount++;						
						break;
					case "BALL":
						$this->ballCount++;
						break;
					case "HBP" :
						$this->q->enqueue(1,$HitterName);
						break;
					case "STRIKE":
						$this->strikeCount++;
						break;
					case "SO":
						$this->outCount++;
						break;
					case "BB":
						$this->q->enQueue(1,$HitterName);
						break;
					default :
						die("result() error");
				}
		}
		
		private function judge($HitterName,$val){
			
			switch($val){
				case "B1": 
				case "B2": 
				case "B3": 
				case "HR": 
				case "GO": 
				case "AO": 
					$type = "타격";
					$ret = "end";
					break;
				case "foul": 
					$type = "파울"; 
					break;
				case "swing": 
					$type = "헛스윙";
					break;
				case "BALL": 
					$type = "볼";
					break;
				case "HBP" :
					$type = "볼";
					$ret = "end";
					break;
				case "STRIKE": 
					$type = "스트라이크"; 
					break;
				case "SO":
				case "BB":
					$type = "noMsg";
					$ret = "end";
					break;
				default :
					die("HitterName() error");
			}

			if($ret == "end"){
				switch($val){
					case "B1": 
						$translate = "1루타"; 
						break;
					case "B2": 
						$translate = "2루타";
						break;
					case "B3": 
						$translate = "3루타"; 
						break;
					case "HR": 
						$translate = "홈런";
						break;
					case "GO": 
						$translate = "플라이 아웃"; 
						break;
					case "AO": 
						$translate = "땅볼 아웃"; 
						break;
					case "HBP" :
						$translate = "몸에 맞는 볼";
						break;
					case "SO":
						$translate = "삼진 아웃";
						break;
					case "BB":
						$translate = "볼 넷";
						break;
					default :
						die("HitterName() error");
				}
			}
			if($type != "noMsg")
				$this->printer->printBallType($this->inningBallCount, $type);	//echo "-".$this->inningBallCount."구 : ".$type."</br>";
			if($ret == "end"){
				$this->printer->printResult($HitterName, $translate);	//echo $HitterName.": $translate</br>";
				return "break";
			}
			else
				return "continue";
		}		

		public function Play(){
			$this->q->init();
			$this->outCount = 0;

			$PitcherNum = 0;
			if($this->totalBallCount > 100)
				$PitcherNum = $this->pitcherSqe();

			$PicherName = $this->pitcher[$PitcherNum][PNAME];
			$this->printer->printPit($PicherName);	
		
			while($this->outCount < 3){
					$HitterNum = $this->hitterSqe();
					$HitterName = $this->hitter[$HitterNum][HNAME];

					$this->printer->printHit($HitterNum,$HitterName);	
					
					$this->inningBallCount = 0;
					$this->ballCount = 0;
					$this->strikeCount = 0;

					while($this->ballCount < 4 && $this->strikeCount < 3){
						$this->totalBallCount++;
						$this->inningBallCount++;
						
						if($this->batSwingRate($HitterNum) > $this->randFloat()){
							if($this->battingAverage($PitcherNum,$HitterNum) > $this->randFloat())
								$typ = $this->hitTypes($HitterNum);								
							else
								$typ= $this->nonHitTypes($HitterNum);
						}
						else
							$typ= $this->ballsTypes($PitcherNum);
						
						$ret = $this->judge($HitterName,$typ);
						$this->result($HitterName,$typ);
						
						$typ = $this->countBall($HitterName);
						if($typ == "BB" || $typ == "SO"){
							$ret = $this->judge($HitterName,$typ);
							$this->result($HitterName,$typ);
						}
						
						if($ret == "break")
							break;
					}
			}
		}

		private function hitterSqe(){			
			$this->h_Sqe = ($this->h_Sqe + 1) % count($this->hitter);
			return $this->h_Sqe;
		}

		private function pitcherSqe(){
			if($this->p_Sqe != count($this->pitcher) -1)
				$this->p_Sqe = $this->p_Sqe + 1;
			else
				$this->p_Sqe = $this->p_Sqe;
			
			return $this->p_Sqe;
		}

		public function getPitcher(){
			return $this->pitcher;
		}

		public function getHitter(){
			return $this->hitter;
		}

		public function getVs(){
			return $this->vs;
		}
	}
?>