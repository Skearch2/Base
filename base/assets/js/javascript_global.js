/*
 * 	This is the global JS from PMD
 *  Dump and replace as soon as possible.
 * 
 */ 

function htmlspecialchars(str) {
    if(typeof(str) == "string") {
        str = str.replace(/&/g, "&amp;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
    }
    return str;
}

function newWindow(mypage,myname,w,h,features) {
    if(screen.width) {
          var winl = (screen.width-w)/2;
          var wint = (screen.height-h)/2;
      } else {
          winl = 0;wint =0;
      }

      if (winl < 0) winl = 0;
      if (wint < 0) wint = 0;

      var settings = 'height=' + h + ',';
      settings += 'width=' + w + ',';
      settings += 'top=' + wint + ',';
      settings += 'left=' + winl + ',';
      settings += features;
      settings += ' scrollbars=yes ';

      win = window.open(mypage,myname,settings);

      win.window.focus();
}

var timer_handles = [];
function set_timer(id,code,time) {
    if(id in timer_handles) {
        clearTimeout(timer_handles[id]);
    }
    timer_handles[id] = setTimeout(code,time)
}

$(document).ready(function(){
    $.ajaxSetup({
        error: function(x,e){
            if(x.status==0) {
                // Do nothing, this results in bad popups if changing pages fast
            } else if(x.status==404) {
                alert('Requested URL not found.');
            } else if(x.status==401) {
                window.location = x.responseText;
            } else if(x.status==302) {
                window.location = x.responseText;
            } else if(x.status==500) {
                if(x.responseText == 'Bad Token') {
                    location.reload(true);
                } else {
                    //alert('Internal Server Error\n'+x.responseText);
                }
            } else if(e=='parsererror') {
                alert('Error.\nParsing request failed.');
            } else if(e=='timeout') {
                alert('Request Time out.');
            } else {
                alert('Unknown Error.\n'+x.responseText);
            }
        }
    });
});

function updatecount(id,type,banner_type){
  //var BASE_URL = '<?php echo BASE_URL; ?>';    
  //alert(banner_type);
    $.ajax({
        url: SITEURL+'/ajax.php',
        type: 'POST',
        data: {action:'update_count',id:id,type:type,from_pmd:from_pmd1,b_type:banner_type},
        async: true,
        error: function () {
        },
        beforeSend: function () {
        },
        success: function (rsp) {
        }
  });
}

function updatebottomcount(id,type){
  //var BASE_URL = '<?php echo BASE_URL; ?>';    
  //var from_pmd = '<?php echo $from_pmd;?>';
    $.ajax({
        url: SITEURL+'/ajax.php',
        type: 'POST',
        data: {action:'update_bottom_count',id:id,type:type,from_pmd:from_pmd1},
        async: true,
        error: function () {
        },
        beforeSend: function () {
        },
        success: function (rsp) {
        }
  });
}

function update_impression(id){
    $.ajax({
        url: SITEURL+'/ajax.php',
        type: 'POST',
        data: {action:'update_impression',id:id,from_pmd:from_pmd1},
        async: true,
        error: function () {
        },
        beforeSend: function () {
        },
        success: function (rsp) {
        }
  });
}

function update_right_impression(id, is_field, banner_type){
  //alert(banner_type)
   $.ajax({
        url: SITEURL+'/ajax.php',
        type: 'POST',
        data: {action:'update_right_impression',id:id,from_pmd:from_pmd1,type:is_field,type:banner_type},
        async: true,
        error: function () {
        },
        beforeSend: function () {
        },
        success: function (rsp) {
        }
  });
}


