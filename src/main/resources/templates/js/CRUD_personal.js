function borrarPersonal(idInst){
        
    var idEliminar={
        id:idInst
    }   
    $.ajax({
        type: "DELETE",
        url: app_inst.backend+'/'+idInst,
        data: JSON.stringify(idEliminar),
        dataType: "JSON",
        contentType: "application/json",
        success: function (response) {
            location.reload();
        }
    })
}
function editarPersonal(idInst){
    $.ajax({
        type: "GET",
        url: app_inst.backend+"/"+idInst,
        dataType: "JSON",
        
        success: function (data) {
            $("#edit_id_inst").empty().val(data.idPer);
            $("#edit_cedu_inst").empty().val(data.documento);
            $("#edit_nomb_inst").empty().val(data.nombrePersonal);
            $("#edit_carg_inst").empty().val(data.cargo);
        }
    });
}
app_inst={
    // Se llama la url del controller de intructores 
    backend: "http://localhost:8080/api/PersonalCenigrafModel",
    // Se DataTable para darle un diseño por defecto de jquery 
    leer_inst: function(){     
        $.ajax({
            
            url: app_inst.backend + "/all",
            type: 'GET',
            datatype: 'JSON',
            success: function (response) {
                var myItems= response;
                var valor = '';
                for (i = 0; i < myItems.length; i++) {
                    valor +='<tr>'+
                                '<td>'+ myItems[i].documento+'</td>'+
                                '<td>'+ myItems[i].nombrePersonal+'</td>'+
                                '<td>'+ myItems[i].cargo+'</td>'+
                                '<td>'+'<button class="btn btn-danger" onclick="borrarPersonal('+ myItems[i].idPer+')">Borrar</button>'+'</td>'+
                                '<td>'+"<button type='button' class='btn btn-success' onclick='editarPersonal("+ myItems[i].idPer+")' data-toggle='modal' data-target='#editari'>Editar <i class='bi bi-pencil'></i></button>"+'</td>'+
                            '</tr>'
                }
                $("#body_inst").html(valor);
            }
        })
    },
    reg_inst: function(){
        $("#reg_personal").click(function() { 
            var reg_instru_docu=$("#reg_instru_docu").val();
            var reg_instru_nomb=$("#reg_instru_nomb").val();
            var reg_instru_carg=$("#reg_instru_carg").val();
            var obj_prog={
                documento:reg_instru_docu,
                nombrePersonal:reg_instru_nomb,
                cargo:reg_instru_carg,
            }
            $.ajax({
                type: "POST",
                url: app_inst.backend + "/save",
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
    actualizar_inst(){
        $('#formulario_act_ins').on("click", function (event){
            event.preventDefault();
         })

        $("#cambios_inst").click(function(){

            var edit_id_inst=$("#edit_id_inst").val();
            var edit_cedu_inst=$("#edit_cedu_inst").val();
            var edit_nomb_inst=$("#edit_nomb_inst").val();
            var edit_carg_inst=$("#edit_carg_inst").val();

            var datos_editados={
                idPer:edit_id_inst,
                documento:edit_cedu_inst,
                nombrePersonal:edit_nomb_inst,
                cargo:edit_carg_inst,
            }

            var datosJSON=JSON.stringify(datos_editados);
            
            $.ajax({   
                type: "PUT",
                url: app_inst.backend+"/update",
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
    app_inst.leer_inst();
    app_inst.reg_inst();
    app_inst.actualizar_inst();
});