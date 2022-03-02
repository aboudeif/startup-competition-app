<html>
  <head>
    <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>PHP Functions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200&display=swap" rel="stylesheet">
  </head>
  <body dir="rtl">
    <script>
      function build(counter,title) {
        var stage_number = counter >= 1 ? " [ "+ counter +" ]" : "";
        document.getElementById('menu').innerHTML += "<a href='#_"+ counter +"' onClick='menu();'><div class='menu-item'> "+ title + stage_number +" </div></a>";
      }
      function menu() {
        var menu = document.getElementById('menu');
        if(menu.style.display == 'flex')
          menu.style = 'none';
        else
          menu.style.display = 'flex';
      }
    </script>
    <nav>
      <button class="menu-icon" onclick="menu();">---</button>
      <div class="menu" id="menu"></div>
    </nav>
   <!-- التعريف بالمسابقة -->
    <?php
      # read company's names from a json file
      $data_file = file_get_contents('json/companies_data.json');
      # store company's in an array
      $data = json_decode($data_file,true);
      # read app labels from json file
      $info_file = file_get_contents('json/competition.json');
      # store labels in a constant array
      define('INFO', json_decode($info_file,true));
      # print about devision
      echo "<section class='about'><h2>".INFO['title']."</h2><img src='".INFO['logo']."' /><h2>".INFO['about']."</h2><p>".INFO['info']."</p></section>";
      # generate registerd companies division's menu tab
      echo "<script>build(0,'".INFO['names']."');</script>";
      # print registerd companies division title
      echo "<section><div class='stage' id='_0'><h3>".INFO['names']."</h3></div>" ;
      # print registerd companies
      $sub_counter = 1;
      foreach($data as $key => $value)
         echo "<div class='element' dir='rtl'><span>".$sub_counter++ ."- ". $key . " </span></div>";
      echo "</section>";
      # evaluate companies and print winner's names
      for($winner = $data,$counter = 1,$success_rate = 50; $success_rate > 0; $success_rate /= 2){
        # companies evaluation call
        $winner = evaluate_companies($winner,$success_rate);
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
	# if no company success choose the one has minimum rate from the fail round
        if($winner['all_companies_failed']){
	  # delete stage title and status
          unset($winner['stage_title']);
          unset($winner['all_companies_failed']);
          $winner_one = array_search(min($winner),$winner);
	# print winner's division name
        echo "<section><div class='stage' id='_".$counter++."'><h3> ".INFO['winner']." </h3></div>" ;
	# print winner's name
        echo "<div class='element' dir='rtl'><span>&#11088; 1- ". $winner_one . " </span><small> %".min($winner)." </small></div>";
        echo "</section>";
	# generate its menu tab
	echo "<script>build(-1,' ".INFO['message']." ');</script>";
	# print congratulation message
        echo "<section><div class='message' id='_-1'><div class='cup'>&#129351;</div> ".INFO['congrats']." <b>&nbsp;&nbsp;".$winner_one."&nbsp;&nbsp;</b>  &#11088;&#127881;".INFO['one']." &#9996 </div></section>";
        break;
        }
	# if there are winners
        else{
	  # delete stage title
          unset($winner['stage_title']);
	  # delete status
          unset($winner['all_companies_failed']);
	  # if there is one winner
          if(count($winner) == 1){ 
            # generate its menu tab
	    echo "<script>build(-1,' ".INFO['message']." ');</script>";
	    # print congratulation message
            echo "<section><div class='message' id='_-1'><div class='cup'>&#129351;</div> ".INFO['congrats']." <b>&nbsp;&nbsp;".key($winner)."&nbsp;&nbsp;</b>  &#11088;&#127881;".INFO['one']." &#9996 </div></section>";
            break;
          }
        }
      }
      # companies evaluation function
      function evaluate_companies($data,$success_rate){
	# rate companies
        foreach($data as $key => $value){
          $data[$key] = rand(0,100);
	  # check if company sucsses
          if($data[$key] < $success_rate)
	    # add winner to winners array
            $winner[$key] = $data[$key];
        }
	# if there are winners
        if(is_countable($winner)){
	  # set stage title
          $winner['stage_title'] = INFO['winners'];
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
    # print partner's division
    echo "<section class='partner'><h2>".INFO['partners']."</h2><div class='container'>";
    # print partners info 
    foreach(INFO['partner'] as $key=>$value)
    	echo "<span class='partner-item'><img src='".$value."' height='80px'><p>".$key."</p></span>";
    echo "</div></section>";
    ?>
  </body>
</html>
