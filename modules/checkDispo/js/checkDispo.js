
$(window).load(function() {

  $("#tuteur a").mouseenter(function() {
    $(this).children(".fa").animate({"margin-top": "0"});
  }).mouseleave(function() {
    $(this).children(".fa").animate({"margin-top": "-150px"});
  });

  $("#creneau a").mouseenter(function() {
    $(this).children(".fa").animate({"margin-top": "0"});
  }).mouseleave(function() {
    $(this).children(".fa").animate({"margin-top": "-150px"});
  });

});
