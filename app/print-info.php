<?php

# a function to print about devision
function print_about_devision(){
  echo "<section class='about'><h2>".INFO['title']."</h2><img src='".INFO['logo']."' /><h2>".INFO['about']."</h2><p>".INFO['info']."</p></section>";
}

# a function to print registerd companies division
function print_registerd_companies($data){
  # generate registerd companies division's menu tab
  echo "<script>build(0,'".INFO['names']."');</script>";
  # print registerd companies division title
  echo "<section><div class='stage' id='_0'><h3>".INFO['names']."</h3></div>" ;
  # print registerd companies
  $sub_counter = 1;
  foreach($data as $key => $value)
    echo "<div class='element' dir='rtl'><span>".$sub_counter++ ."- ". $key . " </span></div>";
  echo "</section>";     
}
  
# a function to print partner's division
function print_partner_division(){
  echo "<section class='partner'><h2>".INFO['partners']."</h2><div class='container'>";
  # print partners info 
  foreach(INFO['partner'] as $key=>$value)
    echo "<span class='partner-item'><img src='".$value."' height='80px'><p>".$key."</p></span>";
  echo "</div></section>";
}