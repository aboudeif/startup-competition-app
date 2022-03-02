// a function to generate menu tab
      function build(counter,title) {
        var stage_number = counter >= 1 ? " [ "+ counter +" ]" : "";
        document.getElementById('menu').innerHTML += "<a href='#_"+ counter +"' onClick='menu();'><div class='menu-item'> "+ title + stage_number +" </div></a>";
      }
	    
      // a function to display and hide menu
      function menu() {
        var menu = document.getElementById('menu');
        if(menu.style.display == 'flex')
          menu.style = 'none';
        else
          menu.style.display = 'flex';
      }