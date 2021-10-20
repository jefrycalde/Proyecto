/* ********************************************************
Temas
********************************************************* */
$('body').on('click', '.tema', function () {
  var tema = $(this).data('tema');
  $.ajax({
    url: base_url + 'principal/tema',
    data: {tema: tema},
    type: 'POST',
    success: function (resultado) {
      $("#mymain").removeClass();
      $("#mymain").addClass("hold-transition "+ tema +" sidebar-mini");
      return false;
    }
  });
  return false;
});
