$(buscarSP());

function buscarSP(strOrdenjs) {
    $.ajax({
        URL: '../php/rsQ.php',
        type: 'POST',
        dataType: 'html',
        data: {strOrdenjs: strOrdenjs},
    })
    .done(function(resul) {
        $("#showTable").html(resul);
    })
}

$(document).on('keyup', '#txtOrden', function() {
    var getVal =$ (this).val();
    if (getVal != "" || getVal != null) {
        buscarSP(getVal);
    } else {
        buscarSP();
    }
})