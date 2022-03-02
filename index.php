<html>
  <head>
    <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>PHP Functions</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200&display=swap" rel="stylesheet">
  </head>
  <body dir="rtl">

    <?php
      include "layouts/nav.html";
      include "app/evaluate.php";
      include "app/print-info.php";
      include "app/print-result.php";
      # read company's names from a json file
      $data_file = file_get_contents('data/companies_data.json');
      # store company's in an array
      $data = json_decode($data_file,true);
      # read app labels from json file
      $info_file = file_get_contents('data/competition.json');
      # store labels in a constant array
      define('INFO', json_decode($info_file,true));
	  
      # print about devision
      print_about_devision();
	      
      # print registerd companies division
      print_registerd_companies($data);
	      
      # evaluate companies and print winner's names
      for($winner = $data,$counter = 1,$success_rate = 50; $success_rate > 0; $success_rate /= 2){
        
        # evaluate companies
        $winner = evaluate_companies($winner,$success_rate);
	      
	      # print stage division
        $counter = print_stage($winner,$counter,$success_rate);
	
      	# check winner
      	if(check_winner($winner))
      		break;
      }

       # print partner's division
       print_partner_division();
    
    ?>
  </body>
</html>
