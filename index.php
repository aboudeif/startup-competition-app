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
        document.getElementById('menu').innerHTML += "<a href='#_"+ counter +"'><div class='menu-item'> "+ title + counter > 1 ? " [ "+ counter +" ]" : ""; +" </div></a>";
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
      <button class="menu-icon" onclick="menu();">---------</button>
      <div class="menu" id="menu"></div>
    </nav>
    
    <?php 
      define('NOWINNER', 'لم تجتز أي شركة عتبة المرحلة');
      define('WINNER', 'الشركات الفائزة في المرحلة');
    # قراءة البيانات الخاصة بالشركات المشتركة في المنافسة من ملف خارجي وتخزينها في مصفوفة
      $json_file = file_get_contents('companies_data.json');
      $data = json_decode($json_file,true);
	  
      # طباعة اسماء الشركات المسجلة في المسابقة
      echo "<script>build(0,' اسماء الشركات المسجلة في المسابقة');</script>";
        echo "<section><div class='stage' id='_0'><h3>اسماء الشركات المسجلة في المسابقة</h3></div>" ;
        $sub_counter = 1;
          foreach($data as $key => $value)
            echo "<div class='element' dir='rtl'><span>".$sub_counter++ ."- ". $key . " </span></div>";
          echo "</section>";

      # الحلقة التكرارية المسؤولة عن التقييم المتكرر للشركات حتي فوز شركة واحدة
      for($winner = $data,$counter = 1,$success_rate = 50; $success_rate > 0; $success_rate /= 2){
        # استدعاء الدالة المسؤولة عن تقييم الشركات و اختيار الشركات الناجحة
        $winner = successful_companies($winner,$success_rate);
        $title = $winner['stage_title'];
        echo "<script>build(".$counter.",'". $title."');</script>";
        echo "<section><div class='stage' id='_".$counter."'><h3>". $title ." [ ".$counter++ ." ]</h3><h5>عتبة الفوز في هذه المرحلة أقل من  ".$success_rate."% </h5></div>" ;
        $sub_counter = 1;
          foreach($winner as $key => $value){
            if($key == 'all_companies_failed' || $key == 'stage_title')
              continue;
            echo "<div class='element' dir='rtl'><span>".$sub_counter++ ."- ". $key . " </span><small> ".$value."% </small></div>";
          }
          echo "</section>";
        if($winner['all_companies_failed']){
          unset($winner['stage_title']);
          unset($winner['all_companies_failed']);
          $winner_one = array_search(min($winner),$winner);

        echo "<section><div class='stage' id='_".$counter++."'><h3> الشركة الفائزة </h3></div>" ;
            echo "<div class='element' dir='rtl'><span>1- ". $winner_one . " </span><small> %".min($winner)." </small></div>";
          echo "</section>";

          
          
        echo "<section><div class='message'><div class='cup'>&#129351;</div> تهانينا لشركة <b>&nbsp;&nbsp;".$winner_one."&nbsp;&nbsp;</b>  &#11088;&#127881;الفوز بالمركز الأول &#9996 </div></section>";
        break;
        }
        else{
          unset($winner['stage_title']);
          unset($winner['all_companies_failed']);
          if(count($winner) == 1){ 
            
            echo "<section><div class='message'><div class='cup'>&#129351;</div> تهانينا لشركة <b>&nbsp;&nbsp;".key($winner)."&nbsp;&nbsp;</b>  &#11088;&#127881;الفوز بالمركز الأول &#9996 </div></section>";
            break;
          }
        }
        
      }

      function successful_companies($data,$success_rate){
        foreach($data as $key => $value){
          $data[$key] = rand(0,100);
          if($data[$key] < $success_rate)
            $winner[$key] = $data[$key];
        }
        if(is_countable($winner)){
          $winner['stage_title'] = WINNER;
          return $winner;
        }
        else{
          $data['all_companies_failed'] = true;
          $data['stage_title'] = NOWINNER;
          return $data;
        }
      }
    
    ?>
  </body>
</html>
