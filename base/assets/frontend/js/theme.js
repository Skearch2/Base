
$(document).ready(function(){
  $(".dark-logo").hide();
  $(".theme-change .moon").click(function(){
    $(this).hide();
    $("body").addClass("dark");
    $(".theme-change .sun").show();
    $(".light-logo").hide();
    $(".dark-logo").show();
  });
  $(".theme-change .sun").click(function(){
    $(this).hide();
    $("body").removeClass("dark");
    $(".theme-change .moon").show();
    $(".dark-logo").hide();
    $(".light-logo").show();
  });

  $('#button_shuffle').click(function() {
  	shuffleElements( $('li') );
  });

  function shuffleElements($elements) {
  	var i, index1, index2, temp_val;

  	var count = $elements.length;
  	var $parent = $elements.parent();
  	var shuffled_array = [];


  	// populate array of indexes
  	for (i = 0; i < count; i++) {
  		shuffled_array.push(i);
  	}

  	// shuffle indexes
  	for (i = 0; i < count; i++) {
  		index1 = (Math.random() * count) | 0;
  		index2 = (Math.random() * count) | 0;

  		temp_val = shuffled_array[index1];
  		shuffled_array[index1] = shuffled_array[index2];
  		shuffled_array[index2] = temp_val;
  	}

  	// apply random order to elements
  	$elements.detach();
  	for (i = 0; i < count; i++) {
  		$parent.append( $elements.eq(shuffled_array[i]) );
  	}
  }



  /*index*/

  function sortUnorderedList(ul, sortDescending) {
    if(typeof ul == "string")
      ul = document.getElementById(ul);
    var lis = ul.getElementsByTagName("a");
    var vals = [];

    for(var i = 0, l = lis.length; i < l; i++)
      vals.push(lis[i].innerHTML);

    vals.sort();

    if(sortDescending)
      vals.reverse();

    for(var i = 0, l = lis.length; i < l; i++)
      lis[i].innerHTML = vals[i];
  }

  window.onload = function() {
    var desc = false;
    document.getElementById("sort-btn").onclick = function() {
      sortUnorderedList("GFG_UP", desc);
      desc = !desc;
      return false;
    }
  }



});
