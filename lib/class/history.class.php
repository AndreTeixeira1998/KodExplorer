<?php 
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/


/**
* Operation history class
* Incoming or construct an array. Like this:
* Array (
* 'History_num' => 20, // total number of queue node
* 'First' => 0, // starting position, starting from 0. Array index value
* 'Last' => 0, // end position, starting from 0.
* 'Back' => 0, // how many steps backwards from the first position, the difference.
* 'History' => array (// array, store operation queue.
* Array ( 'path' => 'D: /'),
* Array ( 'path' => 'D: / www /'),
* Array ( 'path' => 'E: /'),
* Array ( 'path' => '/ home /')
* ......
*)
*)
*/

class history{
	var $history_num;
	var $first;
	var $last;
	var $back;
	var $history=array();

	function __construct($array=array(),$num=20){
		if (!$array) {//The array is empty. Construct a circular queue.
			$history=array();
			for ($i=0; $i < $num; $i++) {
				array_push($history,array('path'=>''));
			}
			$array=array(
				'history_num'=>$num,
				'first'=>0,//starting point
				'last'=>0,//End position
				'back'=>0,	
				'history'=>$history
			);
		}		
		$this->history_num=$array['history_num'];
		$this->first=$array['first'];
		$this->last=$array['last'];
		$this->back=$array['back'];	
		$this->history=$array['history'];	
	}

	function nextNum($i,$n=1){//n A lower value loop. And a clock loop is similar.
		return ($i+$n)<$this->history_num ? ($i+$n):($i+$n-$this->history_num);
	}
	function prevNum($i,$n=1){//On the loop value ie. N fallback positions.
		return ($i-$n)>=0 ? ($i-$n) : ($i-$n+$this->history_num);		
	}

	function minus($i,$j){//Clockwise're just two points, i-j
		return ($i > $j) ? ($i - $j):($i-$j+$this->history_num);
	}


	function getHistory(){//Returns an array for storing or sequential operations.
		return array(
			'history_num'=> $this->history_num,
			'first'		 => $this->first,			
			'last'		 => $this->last,
			'back'		 => $this->back,			
			'history'	 => $this->history
		);
	}

	function add($path){
		if ($path==$this->history[$this->first]['path']) {//And finally the same, no record
			return 0;
		}
		if ($this->back!=0) {//Back recorded under operating conditions, for insertion.
			$this->goedit($path);
			return;
		}		
		if ($this->history[0]['path']=='') {//Just structure, without adding a. Is not the first advance
			$this->history[$this->first]['path']=$path;
			return;
		}else{
			$this->first=$this->nextNum($this->first);//First forward
			$this->history[$this->first]['path']=$path;			
		}
		if ($this->first==$this->last) {//Start position and end position to meet
			$this->last=$this->nextNum($this->last);//The end of the forward position.
		}		
	}

	function goback(){//Return to step back from the first N address.
		$this->back+=1;
		//Maximum number of setbacks as a starting point to the end point of difference (the difference between the clockwise)
		$mins=$this->minus($this->first,$this->last);
		if ($this->back >= $mins) {//Retreated to the last point
			$this->back=$mins;
		}

		$pos=$this->prevNum($this->first,$this->back);
		return $this->history[$pos]['path'];
	}

	function gonext(){//Back from the first N paces forward.
		$this->back-=1;
		if ($this->back<0) {//Retreated to the last point
			$this->back=0;
		}
		return $this->history[$this->prevNum($this->first,$this->back)]['path'];
	}
	function goedit($path){//Back to a point, but did not advance to modify. The firs is the last value.
		$pos=$this->minus($this->first,$this->back);
		$pos=$this->nextNum($pos);//next	
		$this->history[$pos]['path']=$path;
		$this->first=$pos;
		$this->back=0;
	}

	//Take it back
	function isback(){
		if ($this->back==0 && $this->first==0 && $this->last==0) {
			return 0;
		}
		if ($this->back < $this->minus($this->first,$this->last)) {
			return 1;
		}
		return 0;
	}
	//I can forward
	function isnext(){
		if ($this->back>0) {
			return 1;
		}
		return 0;
	}
	//Remove the latest record
	function getFirst(){
		return $this->history[$this->first]['path'];
	}
}

// Include 'common.function.php';
// $ Hi = new history (array (), 6); // pass an empty array, then initialize the array configuration.
// For ($ i = 0; $ i <8; $ i ++) {
// $ Hi-> add ( 's' $ i.);
//}
// Pr ($ hi-> goback ());
// Pr ($ hi-> gonext ());
// $ Hi-> add ( 'asdfasdf2');
// Pr ($ hi-> getHistory ());


// $ Ss = new history ($ hi-> getHistory ()); // array constructors directly.
// $ Ss-> add ( 'asdfasdf');
// $ Ss-> goback ();
// Pr ($ ss-> getHistory ());
