<?php

# a function to print stage division
function print_stage($winner,$counter,$success_rate){
  # generate stage division menu tab
  echo "<script>build(".$counter.",'". $winner['stage_title']."');</script>";
  # print stage division title 
  echo "<section><div class='stage' id='_".$counter."'><h3>". $winner['stage_title'] ." [ ".$counter++ ." ]</h3><h5>".INFO['threshold']."  ".$success_rate."% </h5></div>" ;
  # print stage winners
  $sub_counter = 1;
  foreach($winner as $key => $value){
  # escape stage title and status
  if($key == 'all_companies_failed' || $key == 'stage_title')
    continue;
    echo "<div class='element' dir='rtl'><span>&#11088; ".$sub_counter++ ."- ". $key . " </span><small> ".$value."% </small></div>";
    }
  echo "</section>";
  return $counter;
}

# a function to print winner division
function print_winner($winner_one, $winner){
	# print winner's division name
  echo "<section><div class='stage' id='_".$counter++."'><h3> ".INFO['winner']." </h3></div>" ;
	# print winner's name
  echo "<div class='element' dir='rtl'><span>&#11088; 1- ". $winner_one . " </span><small> ".min($winner)."% </small></div>";
  echo "</section>";
}
	  
# a function to print congratulation message
function print_congrats($winner_one){
	# generate its menu tab
	echo "<script>build(-1,' ".INFO['message']." ');</script>";
	# print congratulation message
  echo "<section><div class='message' id='_-1'><div class='cup'>&#129351;</div> ".INFO['congrats']." <b>&nbsp;&nbsp;".$winner_one."&nbsp;&nbsp;</b>  &#11088;&#127881;".INFO['one']." &#9996 </div></section>";
}