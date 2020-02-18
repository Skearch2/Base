
$(document).ready(function(){
  $(".theme-change .moon").click(function(){
    $(this).hide();
    $("body").addClass("dark");
    $(".theme-change .sun").show();
  });
  $(".theme-change .sun").click(function(){
    $(this).hide();
    $("body").removeClass("dark");
    $(".theme-change .moon").show();
  });
});
