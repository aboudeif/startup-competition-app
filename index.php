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
      # قراءة البيانات الخاصة بالشركات المشتركة في المنافسة من ملف خارجي وتخزينها في مصفوفة
      $data_file = file_get_contents('json/companies_data.json');
      $data = json_decode($data_file,true);
      # قراءة البيانات الخاصة بالمسابقة من ملف خارجي وتخزينها في مصفوفة
      $info_file = file_get_contents('json/competition.json');
      define('INFO', json_decode($info_file,true));
      
      echo "<section class='about'><h2>".$info['title']."</h2><img src='".$info['logo']."' /><h2>عن المسابقة</h2><p>".$info['info']."</p></section>";

	  
      # طباعة اسماء الشركات المسجلة في المسابقة
      echo "<script>build(0,'".INFO['names']."');</script>";
        echo "<section><div class='stage' id='_0'><h3>".INFO['names']."</h3></div>" ;
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
            echo "<div class='element' dir='rtl'><span>&#11088; ".$sub_counter++ ."- ". $key . " </span><small> ".$value."% </small></div>";
          }
          echo "</section>";
        if($winner['all_companies_failed']){
          unset($winner['stage_title']);
          unset($winner['all_companies_failed']);
          $winner_one = array_search(min($winner),$winner);

        echo "<section><div class='stage' id='_".$counter++."'><h3> الشركة الفائزة </h3></div>" ;
            echo "<div class='element' dir='rtl'><span>&#11088; 1- ". $winner_one . " </span><small> %".min($winner)." </small></div>";
          echo "</section>";

	echo "<script>build(-1,' رسالة التهنئة ');</script>";
        echo "<section><div class='message' id='_-1'><div class='cup'>&#129351;</div> تهانينا لشركة <b>&nbsp;&nbsp;".$winner_one."&nbsp;&nbsp;</b>  &#11088;&#127881;الفوز بالمركز الأول &#9996 </div></section>";
        break;
        }
        else{
          unset($winner['stage_title']);
          unset($winner['all_companies_failed']);
          if(count($winner) == 1){ 
            
	    echo "<script>build(-1,' رسالة التهنئة ');</script>";
            echo "<section><div class='message' id='_-1'><div class='cup'>&#129351;</div> تهانينا لشركة <b>&nbsp;&nbsp;".key($winner)."&nbsp;&nbsp;</b>  &#11088;&#127881;الفوز بالمركز الأول &#9996 </div></section>";
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
          $winner['stage_title'] = INFO['winners'];
          return $winner;
        }
        else{
          $data['all_companies_failed'] = true;
          $data['stage_title'] = INFO['no_winner'];
          return $data;
        }
      }
    echo "<section class='partner'><h2>الشركاء</h2><div class='container'>";
    foreach($info['partner'] as $key=>$value)
    	echo "<span class='partner-item'><img src='".$value."' height='80px'><p>".$key."</p></span>";
    echo "</div></section>";
    ?>
  </body>
</html>
