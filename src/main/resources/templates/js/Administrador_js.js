/*
app_prog= {
    backend_prog: "http://localhost:8080/api/ProgramaModel",
    
    leer_prog: function(){ 
        // Se DataTable para darle un diseño por defecto de jquery  
        $("#tabla_prog").DataTable({
            // Se añadden, editan o quitan elementos de las DataTables
            "ordering": false,
            "info": false,
            "processing": true,
            "paging": false,
            ajax: {
            // Se usa la url para traer información
                url: app_prog.backend_prog + "/all",
                dataSrc:function(JSON){
                    console.log(JSON);
                    return JSON;
                }    
            },
            // Se añaden las columnas segun los nombres dados en el controlador
            columns:[
                {data: "nombrePrograma"},
                {defaultContent: "<button type='button' class='btn btn-success' data-toggle='modal' data-target='#editarp' id='editar_prog'>Editar <i class='bi bi-pencil'></i></button>"},
                {defaultContent: "<button type='button' class='btn btn-danger' id='eliminar_prog'>Eliminar <i class='bi bi-trash3'></i></button>"}
            ]
        })
    },
    registrar_prog: function(){
        $("#add_programa").click(function(){
            $("#instructores_prog").empty();
            $.ajax({
                type: "POST",
                url: app_prog.backend_prog + "/save",
                dataType: "JSON",
                error: function(){
                    alert("Error al importar instructores");
                },
            }).done(function(instructores){
                $.each(instructores, function (i, item) {
                    $("#reg_instructores_prog").append($('<option>',{
                        value: item.id,
                        text: item.name
                    }));
                });
            });
        });
        $("#reg_programa").click(function () { 
            var reg_prog_ficha=$("#reg_prog_ficha").val();
            var reg_prog_prog=$("#reg_prog_prog").val();
            var reg_instructores_prog=$("#reg_instructores_prog").val();
            var obj_prog={
                ficha: reg_prog_ficha,
                programa:reg_prog_prog,
                intructor:reg_instructores_prog
            }
            $.ajax({
                type: "POST",
                url: app_prog.backend_prog + "/save",
                data: JSON.stringify(obj_prog),
                contentType: "application/json",
                success: function (response) {
                    table.ajax.reload();
                    table.draw();
                }
            }).fail(function($xhr){
                var data=$xhr.responseJSON;
            })

        });
    },
    actualizar_prog: function(){
        $("#tabla_prog").on('click', '#editar_prog', function () {

            var id_prog=table.row($(this).parents('<tr>')).id();

            $.ajax({
                url: backend, //+id_prog,
                dataType: "json",
                error: function () {
                    alert("Error en la petición");
                }
            }).done(function(data){
                $("edit_ficha_prog").empty().append(data.id);
                $("edit_prog_prog").val(data.name);
                $("edit_instru_prog").val(data.username);
            })            
        }),
        $("guardar_edit_prog").click(function () { 
            var edit_ficha_prog=$("#edit_ficha_prog").val();
            var edit_prog_prog=$("#edit_prog_prog").val();
            var edit_instru_prog=$("#edit_instru_prog").val();
            var obj_prog={
                ficha: edit_ficha_prog,
                programa:edit_prog_prog,
                intructor:edit_instru_prog
            }
            $.ajax({
                type: "PUT",
                url: "",
                data: JSON.stringify(obj_prog),
                contentType: "application/json",
                success: function (response) {
                    table.ajax.reload();
                    table.draw();

                    $("#editarp").modal('hide')
                }
            }).fail(function($xhr){
                var data=$xhr.responseJSON;
            })         
        });
    },
    eliminar_prog: function(){
        $("#tabla_prog").on('click', '#eliminar_prog', function () {
            
        }),
        $("#guardar_eliminar_prog").click(function () { 
            var eliminar_prog_id= $("#eliminar_prog_id").val();
            $.ajax({
                type: "DELETE",//+ eliminar_prog_id,
                url: "url" ,
                contentType: "application/json",
                success: function (response) {
                    table.ajax.reload();
                    table.draw();

                    $("#editarp").modal('hide')
                }
            }).fail(function($xhr){
                var data=$xhr.responseJSON;
            });
        });
    }
}

app_inst={
    // Se llama la url del controller de intructores 
    backend: "http://localhost:8080/api/InsModel",
    // Se DataTable para darle un diseño por defecto de jquery 
    leer_inst: function(){      
        $("#tabla_inst").DataTable({
            // Se añadden, editan o quitan elementos de las DataTables
            "ordering": false,
            "info": false,
            "processing": true,
            "paging": false,
            // Se usa la url para traer información
            ajax: {
                url: app_inst.backend + "/all",
                dataSrc:function(JSON){
                    return JSON;
                }    
            },
            // Se añaden las columnas segun los nombres dados en el controlador
            columns:[
                {data: "cedula"},
                {data: "nombreInstructor"},
                {data: "celular"},
                {data: "correo"},              
                {defaultContent: "<button type='button' class='btn btn-success' data-toggle='modal' data-target='#editari'>Editar <i class='bi bi-pencil'></i></button>"},
                {defaultContent: "<button type='button' class='btn btn-danger' >Eliminar <i class='bi bi-trash3'></i></button>"}
            ]
        })
    },



    reg_inst:function(){
        $("#reg_instructores").click(function() { 
            var reg_instru_docu=$("#reg_instru_docu").val();
            var reg_instru_nomb=$("#reg_instru_nomb").val();
            var reg_instru_celu=$("#reg_instru_celu").val();
            var reg_instru_corr=$("#reg_instru_corr").val();
            var obj_prog={
                cedula:reg_instru_docu,
                celular:reg_instru_celu,
                correo:reg_instru_corr,
                nombreInstructor:reg_instru_nomb,
                nombre:null
            }
            $.ajax({
                type: "POST",
                url: app_inst.backend + "/save",
                data: JSON.stringify(obj_prog),
                contentType: "application/json",
                success: function (response) {
                    table.ajax.reload();
                    table.draw();
                }
            }).fail(function($xhr){
                var data=$xhr.responseJSON;
            })

        })
    
    }
}

$(document).ready(function(){      
    app_prog.leer_prog();
    app_prog.registrar_prog();
    app_prog.actualizar_prog();
    app_prog.eliminar_prog();
});

 */