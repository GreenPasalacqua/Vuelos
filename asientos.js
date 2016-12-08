var vectorChecks = [];
/**
 * Clic en asientos
 */
$(".seatNumber").click(
    function () {
        if (!$(this).hasClass("seatUnavailable")) {

            var numeroAsientosEscoger = document.getElementById('inputNumeroViajeros').value;

            if ($(this).hasClass("seatSelected")) {
                var id = $(this).attr('id');
                var value = $(this).attr('value');
                var valores = value.split(".");
                var fila = valores[1].charAt(0);
                var columna = valores[1].charAt(1);
                var precio = valores[0];

                var idCheckbox = "checkbox." + id;
                document.getElementById(idCheckbox).checked = false;
                var infoAsiento = precio + "." + fila + columna;
                vectorChecks = vectorChecks.filter(
                    function (item) {
                        return item !== infoAsiento;
                    }
                );
                document.formAsientos.ordenAsientos.value = vectorChecks.toString();

                $(this).removeClass("seatSelected");
                $('#seatsList .' + id).remove();

                actualizarContador();
            } else {
                if ($(".seatSelected").length < numeroAsientosEscoger) {
                    var id = $(this).attr('id');
                    var value = $(this).attr('value');
                    var valores = value.split(".");
                    var fila = valores[1].charAt(0);
                    var columna = valores[1].charAt(1);
                    var precio = valores[0];
                    var detallesDeAsiento = "Fila: " + fila + " Columna: " + columna + " Precio: $" + precio;

                    var idCheckbox = "checkbox." + id;
                    document.getElementById(idCheckbox).checked = true;
                    var infoAsiento = precio + "." + fila + columna;
                    vectorChecks.push(infoAsiento);
                    document.formAsientos.ordenAsientos.value = vectorChecks.toString();

                    $("#seatsList").append('<li value=' + precio + ' class=' + id + '>' + detallesDeAsiento + "</li>");
                    $(this).addClass("seatSelected");

                    actualizarContador();
                }
            }

        }
    }
);

/**
 * Información en hover
 */
$(".seatNumber").hover(
    function () {
        if (!$(this).hasClass("seatUnavailable")) {
            var value = $(this).attr('value');
            var valores = value.split(".");
            var fila = valores[1].charAt(0);
            var columna = valores[1].charAt(1);
            var precio = valores[0];
            var hover = "Fila: " + fila + " Columna: " + columna + " Precio: $" + precio;

            $(this).prop('title', hover);
        } else {
            $(this).prop('title', "Asiendo ocupado");
        }
    }
);

/*
 * Actualizar contador
 */
function actualizarContador() {
    $(".seatsAmount").text($(".seatSelected").length);
}