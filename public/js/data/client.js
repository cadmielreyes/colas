$(document).ready(function () {
    // const url = "http://localhost/sysq/public/";
const url = "http://127.0.0.1:8000/";

    var ci = $('ci').val();

    ci.onkeypress=function(event){

        var er=/^[0-9\b]*$/;
        validarkeypress(er,event);
    }

    ci.onkeyup = function(){
        var er = /^[0-9]{6,12}$/;
        validarkeyup(er,this,
          document.getElementById("mcedula"),
          "La cedula debe ser mayor a 6 caracteres");
      };

      document.querySelectorAll("button.btnNumber").forEach(function(elem) {
	elem.addEventListener('click', agregarTexto, false);
  });

});
        