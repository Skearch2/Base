
$(document).ready(function () {
  $(".theme-change .moon").click(function () {
    $(this).hide();
    $("body").addClass("dark");
    $(".theme-change .sun").show();
    $(".light-logo").hide();
    $(".dark-logo").show();
  });
  $(".theme-change .sun").click(function () {
    $(this).hide();
    $("body").removeClass("dark");
    $(".theme-change .moon").show();
    $(".dark-logo").hide();
    $(".light-logo").show();
  });

});
