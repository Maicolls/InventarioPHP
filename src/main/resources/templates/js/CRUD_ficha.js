function borrarFicha(idFich){
        
    var idEliminar={
        idFicha:idFich
    }   
    $.ajax({
        type: "DELETE",
        url: app_fich.backend+'/'+idFich,
        data: JSON.stringify(idEliminar),
        dataType: "JSON",
        contentType: "application/json",
        success: function (response) {
            location.reload();
        }
    })
}
function editarFicha(idInst){
    $.ajax({
        type: "GET",
        url: app_fich.backend+"/"+idInst,
        dataType: "JSON",
        
        success: function (data) {
            $("#edit_id_fich").empty().val(data.idFicha);
            $("#edit_nomb_fich").empty().val(data.numeroFicha);
        }
    });
}
app_fich={
    // Se llama la url del controller de intructores 
    backend: "http://localhost:8080/api/FichaModel",
    // Se DataTable para darle un diseño por defecto de jquery 
    leer_fich: function(){     
        $.ajax({
            
            url: app_fich.backend + "/all",
            type: 'GET',
            datatype: 'JSON',
            success: function (response) {
                var myItems= response;
                var valor = '';
                for (i = 0; i < myItems.length; i++) {
                    valor += '<tr>' +
                        '<td>' + myItems[i].numeroFicha + '</td>' +
                        '<td>' + '<button class="btn btn-danger" onclick="borrarFicha(' + myItems[i].idFicha + ')">Borrar</button>' + '</td>' +
                        '<td>' + "<button type='button' class='btn btn-success' onclick='editarFicha(" + myItems[i].idFicha + ")' data-toggle='modal' data-target='#editarf'>Editar <i class='bi bi-pencil'></i></button></td>"+
                            '</tr>'
                }
                $("#body_fich").html(valor);
            }
        })
    },
    reg_fich: function(){

        $("#reg_ficha").click(function() { 
            var reg_fic_nomb=$("#reg_fic_nomb").val();

            var obj_prog={
                numeroFicha:reg_fic_nomb,
            }
            $.ajax({
                type: "POST",
                url: app_fich.backend + "/save",
                data: JSON.stringify(obj_prog),
                dataType: 'JSON',
                contentType: "application/json",
                success: function () {
                    location.reload();
                }
            }).fail(function($xhr){
                var data=$xhr.responseJSON;
            })

        });
    },
    actualizar_fich(){

        $('#formulario_act_fic').on("click", function (event){
            event.preventDefault();
         })

        $("#cambios_fich").click(function(){


            var edit_id_fich=$("#edit_id_fich").val();
            var edit_nomb_fich=$("#edit_nomb_fich").val();

            var edit_num_fich=$("#edit_num_fich").val();
            var datos_editados={
                idFicha:edit_id_fich,
                numeroFicha:edit_nomb_fich,
            }

            var datosJSON=JSON.stringify(datos_editados);
            
            $.ajax({   
                type: "PUT",
                url: app_fich.backend+"/update",
                data: datosJSON,
                dataType: "JSON",
                contentType: "application/json",
                success: function () {
                    location.reload();
                }
            });
        });       
    } 
}
$(document).ready(function () {
    app_fich.leer_fich();
    app_fich.reg_fich();
    app_fich.actualizar_fich();
});