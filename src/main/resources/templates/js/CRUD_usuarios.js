app_usua={
    // Se llama la url del controller de intructores 
    backend: "http://localhost:8080/api/UserModel",
    leer_usua: function(){     
        $.ajax({
            url: app_usua.backend + "/all",
            type: 'GET',
            datatype: 'JSON',
            success: function (response) {
                var myItems= response;
                var valor = '';
                for (i = 0; i < myItems.length; i++) {
                    valor +='<tr>'+
                                '<td>'+ myItems[i].nombre+'</td>'+
                                '<td>'+ myItems[i].contrasena+'</td>'+
                                '<td>'+'<button class="btn btn-danger" onclick="borrarUsuario('+ myItems[i].idUsuario+')">Borrar <i class="bi bi-trash3"></i></button>'+'</td>'+
                                '<td>'+"<button type='button' class='btn btn-success' onclick='editarUsuario("+ myItems[i].idUsuario+")' data-toggle='modal' data-target='#editaru'>Editar <i class='bi bi-pencil'></i></button>"+'</td>'+
                            '</tr>'
                }
                $("#body_usua").html(valor);
            }
        })
    },
    reg_usua: function(){
        $("#reg_usuario").click(function() { 
            var reg_usuario_nomb=$("#reg_usuario_nomb").val();
            var reg_usuario_cont=$("#reg_usuario_cont").val();
            var obj_usua={
                nombre:reg_usuario_nomb,
                contrasena:reg_usuario_cont,
            }
            $.ajax({
                type: "POST",
                url: app_usua.backend + "/save",
                data: JSON.stringify(obj_usua),
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
    actualizar_usua(){
        $('#formulario_act_usu').on("click", function (event){
            event.preventDefault();
         })

        $("#cambios_usua").click(function(){

            var edit_id_usua=$("#edit_id_usua").val();
            var edit_nomb_usua=$("#edit_nomb_usua").val();
            var edit_cont_usua=$("#edit_cont_usua").val();

            var datos_editados={
                idUsuario:edit_id_usua,
                nombre:edit_nomb_usua,
                contrasena:edit_cont_usua
            }

            var datosJSON=JSON.stringify(datos_editados);
            
            $.ajax({   
                type: "PUT",
                url: app_usua.backend+"/update",
                data: datosJSON,
                dataType: "JSON",
                contentType: "application/json",
                success: function (data) {
                    location.reload();
                }
            });
        });       
    } 
}
function borrarUsuario(idUsua){
        
    var idEliminar={
        idUsuario:idUsua
    }   
    $.ajax({
        type: "DELETE",
        url: app_usua.backend+'/'+idUsua,
        data: JSON.stringify(idEliminar),
        dataType: "JSON",
        contentType: "application/json",
        success: function (response) {
            location.reload();
        }
    })
}
function editarUsuario(idUsua){
    $.ajax({
        type: "GET",
        url: app_usua.backend+"/"+idUsua,
        dataType: "JSON",
        
        success: function (data) {
            
            $("#edit_id_usua").empty().val(data.idUsuario);
            $("#edit_nomb_usua").empty().val(data.nombre);
            $("#edit_cont_usua").empty().val(data.contrasena);

        }
    });
}
$(document).ready(function () {
    app_usua.leer_usua();
    app_usua.reg_usua();
    app_usua.actualizar_usua();
});