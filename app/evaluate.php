<?php

# a function to evaluate companies
function evaluate_companies($data,$success_rate){
  unset($data['stage_title']);
  unset($data['all_companies_failed']);
	# rate companies
  foreach($data as $key => $value){
    $data[$key] = rand(0,100);
  # check if company sucsses and add it to winners array
  if($data[$key] < $success_rate)
    $winner[$key] = $data[$key];
     }
	# if there are winners set stage title
  if(is_countable($winner)){
    $winner['stage_title'] = INFO['stage'];
	  # send them back
    return $winner;
      }
	# if there are no winners
      else{
  # set group status to 'no winners'
    $data['all_companies_failed'] = true;
  # set stage title
    $data['stage_title'] = INFO['no_winner'];
  # return given group of companies with new rates
    return $data;
     }
  }

# a function to check winner if any
	function check_winner($winner){
	unset($winner['stage_title']);
  # if no company success choose the one has minimum rate from the fail round
  if($winner['all_companies_failed']){
		$winner_one = array_search(min($winner),$winner);
	      }
	# delete stage title and status
  unset($winner['all_companies_failed']);
	# if there is one winner
  if(count($winner) == 1)
		$winner_one = key($winner);
  if($winner_one)
		print_congrats($winner_one);
	return $winner_one;
	 }