function borrarInstructor(idProg){

    var idEliminar={
        id:idProg
    }
    $.ajax({
        type: "DELETE",
        url: app_prog.backend+'/'+idProg,
        data: JSON.stringify(idEliminar),
        dataType: "JSON",
        contentType: "application/json",
        success: function (response) {
            location.reload();
        }
    })
}
function editarPrograma(idProg){
    $.ajax({
        type: "GET",
        url: app_prog.backend+"/"+idProg,
        dataType: "JSON",

        success: function (data) {
            $("#edit_id_prog").empty().val(data.idPrograma);
            $("#edit_nomb_prog").empty().val(data.nombrePrograma);
        }
    });
}

app_prog={
    // Se llama la url del controller de intructores 
    backend: "http://localhost:8080/api/ProgramaModel",
    // Se DataTable para darle un diseño por defecto de jquery 
    leer_prog: function(){     
        $.ajax({
            
            url: app_prog.backend + "/all",
            type: 'GET',
            datatype: 'JSON',
            success: function (response) {
                var myItems= response;
                var valor = '';
                for (i = 0; i < myItems.length; i++) {
                    valor +='<tr>'+
                                '<td>'+ myItems[i].nombrePrograma+'</td>'+

                                '<td>'+'<button class="btn btn-danger" onclick="borrarPrograma('+ myItems[i].idPrograma+')">Borrar <i class="bi bi-trash3"></i></button>'+'</td>'+
                                '<td>'+"<button type='button' class='btn btn-success' onclick='editarPrograma("+ myItems[i].idPrograma+")' data-toggle='modal' data-target='#editarp'>Editar <i class='bi bi-pencil'></i></button>"+'</td>'+
                            '</tr>'
                }
                $("#body_prog").html(valor);
            }
        })
    },
    reg_prog: function(){

        $("#reg_programas").click(function() { 
            var reg_nomb_prog=$("#reg_nomb_prog").val();
            var obj_prog={
                nombrePrograma:reg_nomb_prog,
            }
            $.ajax({
                type: "POST",
                url: app_prog.backend + "/save",
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
    actualizar_prog(){

        $('#formulario_act_pro').on("click", function (event){
            event.preventDefault();
         })

        $("#cambios_prog").click(function(){


            var edit_id_prog=$("#edit_id_prog").val();
            var edit_nomb_prog=$("#edit_nomb_prog").val();


            var datos_editados={
                idPrograma:edit_id_prog,
                nombrePrograma:edit_nomb_prog,
            }

            var datosJSON=JSON.stringify(datos_editados);
            
            $.ajax({   
                type: "PUT",
                url: app_prog.backend+"/update",
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
function borrarPrograma(idprog){
        
    var idEliminar={
        id:idprog
    }   
    $.ajax({
        type: "DELETE",
        url: app_prog.backend+'/'+idprog,
        data: JSON.stringify(idEliminar),
        dataType: "JSON",
        contentType: "application/json",
        success: function (response) {
            location.reload();
        }
    })
}
function editarPrograma(idprog){
    $.ajax({
        type: "GET",
        url: app_prog.backend+"/"+idprog,
        dataType: "JSON",
        
        success: function (data) {
            $("#edit_id_prog").empty().val(data.idPrograma);
            $("#edit_nomb_prog").empty().val(data.nombrePrograma);
        }
    });
}
$(document).ready(function () {
    app_prog.leer_prog();
    app_prog.reg_prog();
    app_prog.actualizar_prog();
});







