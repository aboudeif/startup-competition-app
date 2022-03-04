<?php

# a function to print stage division
function print_stage($winner,$loser,$counter,$success_rate){
  # generate stage division menu tab
  echo "<script>build(".$counter.",'". $winner['stage_title']."');</script>";
  # print stage division title 
  echo "<section><div class='stage' id='_".$counter."'><h3>". $winner['stage_title'] ." [ ".$counter++ ." ]</h3><h5>".INFO['threshold']."  %".$success_rate." </h5></div><div class='stage-container'>" ;
  # print stage winners title
  echo "<section><div class='stage-winner'><h3>". INFO['winners'] ."</h3></div>" ;
  # if no company success
  if($winner['all_companies_failed']){
    # delete meta data from companies array
    $pre_winner = $winner;
    unset($pre_winner['stage_title']);
    unset($pre_winner['all_companies_failed']);
    # set winner = company with minimum sccess rate
    $winner =  array(array_search(min($pre_winner),$pre_winner)=>min($pre_winner));
    # set loser = the rest of not succeed companies
    $loser = $pre_winner;
    unset($loser[array_search(min($pre_winner),$pre_winner)]);
    $loser = array_flip($loser);
  }
  # print stage winners
  $sub_counter = 1;
  foreach($winner as $key => $value){
    # escape stage title and status
    if($key == 'stage_title')
      continue;
    echo "<div class='element' dir='rtl'><span>&#11088; ".$sub_counter++ ."- ". $key . " </span><small> ".$value."% </small></div>";
    }
  echo "</section>";
  # print stage losers title
  echo "<section><div class='stage-loser'><h3>". INFO['losers'] ."</h3></div>" ;
  # print stage losers
  $sub_counter = 1;
  foreach($loser as $key){
    # escape stage title and status
    if($key == 'all_companies_failed' || $key == 'stage_title')
      continue;
    echo "<div class='element' dir='rtl'><span>&#128078; ".$sub_counter++ ."- ". $key . " </span></div>";
    }
  echo "</section></div>";
  return $counter;
}

# a function to print congratulation message
function print_congrats($winner_one){
	# generate its menu tab
	echo "<script>build(-1,' ".INFO['message']." ');</script>";
	# print congratulation message
  echo "<section><div class='message' id='_-1'><div class='cup'>&#129351;</div> ".INFO['gift'][rand(0,14)]." ".INFO['congrats']." <b>&nbsp;&nbsp;".$winner_one."&nbsp;&nbsp;</b>  ".INFO['gift'][rand(0,14)]."&#127881;".INFO['one']." &#9996 </div></section>";
}