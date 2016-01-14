<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {
        ///////Cambio de proyecto///////
       
        $("#idProyecto").change(function () {
            //se limpian las peticiones y los artefactos y se cambian las actividades del proyecto seleccionado
            $("#peticiones").find('tbody').remove();
            $("#artefactos").find('tbody').remove();
            $("#actividades").find('tbody').remove();
            $val = '<tbody><tr><td>No hay información</tbody>';
            $("#peticiones").append($val);
            $("#artefactos").append($val);
            ////// Agregar actividades del nuevo proyecto seleccionado
            mensaje("Agregar peticiones, artefactos y actividades para el proyecto seleccionado.");
            event.preventDefault();
            combo = '';
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/estatus/llenaComboActividades",
                type: "POST",
                data: {}
            }).done(function (data) {
                combo = data;
            }).fail(function (jqXHR, textStatus) {
            });
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/actividades/actividadesFiltro",
                type: "POST",
                data: {idproyecto: $("#idProyecto").val(), default: 1, modificacion: 0}
            }).done(function (data) {
                if (data == 'no')
                {
                    $("#actividades").append($val);
                }
                else
                {
                    var response = $.parseJSON(data);
                    //armar la tabla del modal con las peticiones encontradas
                    $("#actividades").find('tbody').remove();
                    $("#actividades").append('<tbody>');
                    for (i = 0; i < response.length; i++)
                    {  
                        newOptions = '';
                        newOptions += '<tr id="row-' + response[i].idActividad + '">';
                        newOptions += '<td class="hidden"><input type = "hidden" name = "estatus" class = "form-control" value = "' + response[i].idActividad + '" / >'
                        newOptions += '<td>' + response[i].descripcion;
                        newOptions += '<td>' + response[i].duracionHrs;
                        newOptions += '<td><input type = "text" id="hrsReales" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name = "hrsReales" class = "form-control" maxlength = "5" value = "' + response[i].hrsReales + '" / > '
                        newOptions += '<td><input type = "text" name = "responsable" class = "form-control" maxlength = "100" value = "' + response[i].responsable + '" / >'
                        newOptions += '<td>' + combo;
                        newOptions += '<td class="actions">';
                        newOptions += '  <a class="show-delete-modal-actividad" href="#" data-idactividad="' + response[i].idActividad + '" data-toggle="modal" data-target="#modal-eliminar-actividad">';
                        newOptions += '  <i class="fa fa-trash-o"></i></a></td> ';
                        newOptions += '</tr>';
                        $("#actividades").append(newOptions);
                    }
                    $("#actividades").append('</tbody>');
                    $(".show-delete-modal-actividad").bind("click", function (event) {
                        actividad_borrar = $(this).data("idactividad");
                    });
                }

            }).fail(function (jqXHR, textStatus) {
            });
        });
        
        function mensaje($msg)
        {
            $('#mensaje').html($msg);
            $('#mensaje2').html($msg);
            $('#mensaje').show(0).delay(2500).hide(1000);
            $('#mensaje2').show(0).delay(2500).hide(1000);
        }
        //////Eliminar peticion
        var artefacto_borrar = 0;
        $('#mensaje').hide();
        $(".show-delete-modal-peticion").bind("click", function (event) {
            artefacto_borrar = $(this).data("idpeticion");
        });
        $("#confirm-delete-peticion").click(function (event) {
            event.preventDefault();
            $("#row-" + artefacto_borrar).remove();
            $('#modal-eliminar-peticion').modal('hide');
        });
        ////////////

        ////Mostrar modal de peticion
        //traer peticiones para el proyecto seleccionado, si no existen mostrar mensaje, si si existen mostrar modal
        $("#agregarPeticion").click(function (event) {
            event.preventDefault();
            //obtener peticiones agregadas
            peticiones = peticionesSeleccionadas(0, 0);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/peticiones/peticionesProyecto",
                type: "POST",
                data: {idproyecto: $("#idProyecto").val(), peticiones: peticiones, incluirPeticiones: 0}
            }).done(function (data) {
                if (data == 'no')
                {
                    mensaje("No existen peticiones para el proyecto seleccionado.");
                }
                else
                {
                    var response = $.parseJSON(data);
                    //armar la tabla del modal con las peticiones encontradas
                    $("#modalPeticiones").find('tbody').remove();
                    $("#modalPeticiones").append('<tbody>');
                    for (i = 0; i < response.length; i++)
                    {
                        newOptions = '';
                        newOptions += '<tr>';
                        newOptions += '<td class="hidden">' + response[i].idPeticion;
                        newOptions += '<td>' + response[i].nombre;
                        newOptions += '<td>' + response[i].descripcion;
                        newOptions += '<td><input type="checkbox" id="idPeticionModal" name="idPeticionModal[]" value="' + response[i].idPeticion + '"/>Asignar</td>';
                        newOptions += '</tr>';
                        $("#modalPeticiones").append(newOptions);
                    }
                    $("#modalPeticiones").append('</tbody>');
                    $('#modal-peticiones').modal('show');
                }

            }).fail(function (jqXHR, textStatus) {
            });
        });
        /////////

        function peticionesSeleccionadas(modal, json)
        {
            peticiones = '';
            $("#peticiones tbody tr").each(function (index) {
                if (($(this).find("td")).eq(0).text().trim() != 'No hay información')
                {
                    if (peticiones == '')
                    {
                        if (json == 1)
                            peticiones = '{"id":' + (($(this).find("td")).eq(0).text()) + '}';
                        else
                            peticiones = (($(this).find("td")).eq(0).text());
                    }
                    else
                    {
                        if (json == 1)
                            peticiones = peticiones + ',{"id":' + (($(this).find("td")).eq(0).text()) + '}';
                        else
                            peticiones = peticiones + "," + (($(this).find("td")).eq(0).text());
                    }
                }
            });

            if (modal == 1)
            {
                var table = document.getElementById('modalPeticiones');
                var inputs = table.getElementsByTagName('input');
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].type == 'checkbox' && inputs[i].checked == 1) {
                        if (peticiones == '')
                            peticiones = inputs[i].value;
                        else
                            peticiones = peticiones + "," + inputs[i].value;
                    }
                }
            }
            if (json == 1 && peticiones != "")
                peticiones = "[" + peticiones + "]";
            return peticiones;
        }
        /////////Evento para obtener las peticiones seleccionadas en el modal
        $("#confirm-peticionModal").click(function (event) {
            event.preventDefault();
            //obtener peticiones agregadas
            peticiones = peticionesSeleccionadas(1, 0);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/peticiones/peticionesProyecto",
                type: "POST",
                data: {idproyecto: $("#idProyecto").val(), peticiones: peticiones, incluirPeticiones: 1}
            }).done(function (data) {
                if (data == 'no')
                {
                    $('#modal-peticiones').modal('hide');
                    mensaje("No existen peticiones para el proyecto seleccionado.");
                }
                else
                {
                    var response = $.parseJSON(data);
                    //armar la tabla del modal con las peticiones encontradas
                    $("#peticiones").find('tbody').remove();
                    $("#peticiones").append('<tbody>');
                    for (i = 0; i < response.length; i++)
                    {
                        newOptions = '';
                        newOptions += '<tr id="row-' + response[i].idPeticion + '">';
                        newOptions += '<td class="hidden">' + response[i].idPeticion;
                        newOptions += '<td>' + response[i].nombre;
                        newOptions += '<td>' + response[i].descripcion;
                        newOptions += '<td class="actions">';
                        newOptions += '  <a class="show-delete-modal-peticion" href="#" data-idpeticion="' + response[i].idPeticion + '" data-toggle="modal" data-target="#modal-eliminar-peticion">';
                        newOptions += '  <i class="fa fa-trash-o"></i></a> </td> ';
                        newOptions += '</tr>';
                        $("#peticiones").append(newOptions);
                    }
                    $("#peticiones").append('</tbody>');
                    $(".show-delete-modal-peticion").bind("click", function (event) {
                        artefacto_borrar = $(this).data("idpeticion");
                    });
                    $('#modal-peticiones').modal('hide');
                }

            }).fail(function (jqXHR, textStatus) {
            });
        });
        /////////// Artefactoooosssss///////////////////////////////
        //////Eliminar artefacto
        var artefacto_borrar = 0;
        $(".show-delete-modal-artefacto").bind("click", function (event) {
            artefacto_borrar = $(this).data("idartefacto");
        });
        $("#confirm-delete-artefacto").click(function (event) {
            event.preventDefault();
            $("#row-" + artefacto_borrar).remove();
            $('#modal-eliminar-artefacto').modal('hide');
        });
        ////////////

        ////Mostrar modal de artefacto
        //traer artefactos para el proyecto seleccionado, si no existen mostrar mensaje, si si existen mostrar modal
        $("#agregarArtefacto").click(function (event) {
            event.preventDefault();
            //obtener peticiones agregadas
            artefactos = artefactosSeleccionados(0, 0);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/artefactos/artefactosProyecto",
                type: "POST",
                data: {idproyecto: $("#idProyecto").val(), artefactos: artefactos, incluirArtefactos: 0}
            }).done(function (data) {
                if (data == 'no')
                {
                    mensaje("No existen artefactos para el proyecto seleccionado.");
                }
                else
                {
                    var response = $.parseJSON(data);
                    //armar la tabla del modal con las peticiones encontradas
                    $("#modalArtefactos").find('tbody').remove();
                    $("#modalArtefactos").append('<tbody>');
                    for (i = 0; i < response.length; i++)
                    {
                        newOptions = '';
                        newOptions += '<tr>';
                        newOptions += '<td class="hidden">' + response[i].idArtefacto;
                        newOptions += '<td>' + response[i].descripcion;
                        newOptions += '<td><input type="checkbox" id="idArtefactoModal" name="idArtefactoModal[]" value="' + response[i].idArtefacto + '"/>Asignar</td>';
                        newOptions += '</tr>';
                        $("#modalArtefactos").append(newOptions);
                    }
                    $("#modalArtefactos").append('</tbody>');
                    $('#modal-artefactos').modal('show');
                }

            }).fail(function (jqXHR, textStatus) {
            });
        });
        /////////

        function artefactosSeleccionados(modal, json)
        {
            artefactos = '';
            $("#artefactos tbody tr").each(function (index) {
                if (($(this).find("td")).eq(0).text().trim() != 'No hay información')
                {
                    if (artefactos == '')
                    {
                        if (json == 1)
                            artefactos = '{"id":' + (($(this).find("td")).eq(0).text()) + '}';
                        else
                            artefactos = (($(this).find("td")).eq(0).text());
                    }
                    else
                    {
                        if (json == 1)
                            artefactos = artefactos + ',{"id":' + (($(this).find("td")).eq(0).text()) + '}';
                        else
                            artefactos = artefactos + "," + (($(this).find("td")).eq(0).text());
                    }
                }
            });

            if (modal == 1)
            {
                var table = document.getElementById('modalArtefactos');
                var inputs = table.getElementsByTagName('input');
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].type == 'checkbox' && inputs[i].checked == 1) {
                        if (artefactos == '')
                            artefactos = inputs[i].value;
                        else
                            artefactos = artefactos + "," + inputs[i].value;
                    }
                }
            }
            if (json == 1 && artefactos != "")
                artefactos = "[" + artefactos + "]";
            return artefactos;
        }
        /////////Evento para obtener los artefactos seleccionados en el modal
        $("#confirm-artefactoModal").click(function (event) {
            event.preventDefault();
            //obtener peticiones agregadas
            artefactos = artefactosSeleccionados(1, 0);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/artefactos/artefactosProyecto",
                type: "POST",
                data: {idproyecto: $("#idProyecto").val(), artefactos: artefactos, incluirArtefactos: 1}
            }).done(function (data) {
                if (data == 'no')
                {
                    $('#modal-artefactos').modal('hide');
                    mensaje("No existen artefactos para el proyecto seleccionado.");
                }
                else
                {
                    var response = $.parseJSON(data);
                    //armar la tabla del modal con las peticiones encontradas
                    $("#artefactos").find('tbody').remove();
                    $("#artefactos").append('<tbody>');
                    for (i = 0; i < response.length; i++)
                    {
                        newOptions = '';
                        newOptions += '<tr id="row-' + response[i].idArtefacto + '">';
                        newOptions += '<td class="hidden">' + response[i].idArtefacto;
                        newOptions += '<td>' + response[i].descripcion;
                        newOptions += '<td class="actions">';
                        newOptions += '  <a class="show-delete-modal-artefacto" href="#" data-idartefacto="' + response[i].idArtefacto + '" data-toggle="modal" data-target="#modal-eliminar-artefacto">';
                        newOptions += '  <i class="fa fa-trash-o"></i></a> </td> ';
                        newOptions += '</tr>';
                        $("#artefactos").append(newOptions);
                    }
                    $("#artefactos").append('</tbody>');
                    $(".show-delete-modal-artefacto").bind("click", function (event) {
                        artefacto_borrar = $(this).data("idartefacto");
                    });
                    $('#modal-artefactos').modal('hide');
                }

            }).fail(function (jqXHR, textStatus) {
            });
        });
//////////////////////////////////////////ACTIVIDADES////////////
        //////Eliminar actividad
        var actividad_borrar = 0;
        $(".show-delete-modal-actividad").bind("click", function (event) {
            actividad_borrar = $(this).data("idactividad");
        });
        $("#confirm-delete-actividad").click(function (event) {
            event.preventDefault();
            $("#row-" + actividad_borrar).remove();
            $('#modal-eliminar-actividad').modal('hide');
        });
        ////////////

        ////Mostrar modal de actividad
        //traer actividades para el proyecto seleccionado, si no existen mostrar mensaje, si si existen mostrar modal
        $("#agregarActividad").click(function (event) {
            event.preventDefault();
            //obtener actividad agregadas
            actividades = actividadesSeleccionadas(0, 0);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/actividades/actividadesProyecto",
                type: "POST",
                data: {idproyecto: $("#idProyecto").val(), actividades: actividades, incluirActividades: 0}
            }).done(function (data) {
                if (data == 'no')
                {
                    mensaje("No existen actividades para el proyecto seleccionado.");
                }
                else
                {
                    var response = $.parseJSON(data);
                    //armar la tabla del modal con las peticiones encontradas
                    $("#modalActividad").find('tbody').remove();
                    $("#modalActividad").append('<tbody>');
                    for (i = 0; i < response.length; i++)
                    {
                        newOptions = '';
                        newOptions += '<tr>';
                        newOptions += '<td class="hidden">' + response[i].idActividad;
                        newOptions += '<td>' + response[i].descripcion;
                        newOptions += '<td><input type="checkbox" id="idActividadModal" name="idActividadModal[]" value="' + response[i].idActividad + '"/>Asignar</td>';
                        newOptions += '</tr>';
                        $("#modalActividad").append(newOptions);
                    }
                    $("#modalActividad").append('</tbody>');
                    $('#modal-actividades').modal('show');
                }

            }).fail(function (jqXHR, textStatus) {
            });
        });
        /////////

        function actividadesSeleccionadas(modal, json)
        {
            actividades = '';
            if (json == 1)
            {
                var table = document.getElementById('actividades');
                var inputs = table.getElementsByTagName('input');
                var combos = table.getElementsByTagName('select');
                var index = 0;
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].type == 'hidden') {
                        if (actividades == '') {
                            actividades = '{"id":' + inputs[i].value;
                        }
                        else {
                            actividades = actividades + ',{"id":' + inputs[i].value;
                        }
                    }
                    if (inputs[i].name == 'hrsReales')
                        actividades = actividades + ',"hrsReales":' + inputs[i].value;

                    if (inputs[i].name == 'responsable')
                    {
                        actividades = actividades + ',"responsable":"' + inputs[i].value + '"';
                        actividades = actividades + ',"idEstatus":' + combos[index].value + "}";
                        index = index + 1;
                    }
                }
                if (actividades != "")
                    actividades = "[" + actividades + "]";
            }
            else
            {
                $("#actividades tbody tr").each(function (index) {
                    if (($(this).find("td")).eq(0).text().trim() != 'No hay información')
                    {
                        if (actividades == '') {
                            actividades = (($(this).find("td")).eq(0).text());
                        }
                        else {
                            actividades = actividades + "," + (($(this).find("td")).eq(0).text());
                        }
                    }
                });
                if (modal == 1)
                {
                    var table = document.getElementById('modalActividad');
                    var inputs = table.getElementsByTagName('input');
                    for (var i = 0; i < inputs.length; i++) {
                        if (inputs[i].type == 'checkbox' && inputs[i].checked == 1) {
                            if (actividades == '')
                                actividades = inputs[i].value;
                            else
                                actividades = actividades + "," + inputs[i].value;
                        }
                    }
                }
            }
            return actividades;
        }
        /////////Evento para obtener las actividades seleccionadas en el modal
        $("#confirm-actividadModal").click(function (event) {
            event.preventDefault();
            //obtener peticiones agregadas
            actividades = actividadesSeleccionadas(1, 0);
            combo = '';
            $.ajax({url: "<?php echo base_url(); ?>index.php/estatus/llenaComboActividades",
                type: "POST",
                data: {}
            }).done(function (data) {
                combo = data;
            }).fail(function (jqXHR, textStatus) {
            });
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/actividades/actividadesProyecto",
                type: "POST",
                data: {idproyecto: $("#idProyecto").val(), actividades: actividades, incluirActividades: 1}
            }).done(function (data) {
                if (data == 'no')
                {
                    $('#modal-actividades').modal('hide');
                    mensaje("No existen actividades para el proyecto seleccionado.");
                }
                else
                {
                    var response = $.parseJSON(data);
                    //armar la tabla del modal con las peticiones encontradas
                    $("#actividades").find('tbody').remove();
                    $("#actividades").append('<tbody>');
                    for (i = 0; i < response.length; i++)
                    {
                        newOptions = '';
                        newOptions += '<tr id="row-' + response[i].idActividad + '">';
                        newOptions += '<td class="hidden"><input type="hidden" name="estatus" value="' + response[i].idActividad + '" />' + response[i].idActividad;
                        newOptions += '<td>' + response[i].descripcion;
                        newOptions += '<td>' + response[i].duracionHrs;
                        newOptions += '<td><input type = "text" id="hrsReales" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name = "hrsReales" class = "form-control" maxlength = "5" value = "' + response[i].hrsReales + '" / > '
                        newOptions += '<td><input type = "text" name = "responsable" class = "form-control" maxlength = "100" value = "' + response[i].responsable + '" / >'
                        newOptions += '<td>' + combo;
                        newOptions += '<td class="actions">';
                        newOptions += '  <a class="show-delete-modal-actividad" href="#" data-idactividad="' + response[i].idActividad + '" data-toggle="modal" data-target="#modal-eliminar-actividad">';
                        newOptions += '  <i class="fa fa-trash-o"></i></a></td> ';
                        newOptions += '</tr>';
                        $("#actividades").append(newOptions);
                    }
                    $("#actividades").append('</tbody>');
                    $(".show-delete-modal-actividad").bind("click", function (event) {
                        actividad_borrar = $(this).data("idactividad");
                    });
                    $('#modal-actividades').modal('hide');
                }

            }).fail(function (jqXHR, textStatus) {
            });
        });
        /////////////////////////////////Termina actividades////////////////////
        $("#limpiar").click(function (event) {
            location.reload();
        });
        ////////////////////////Guardar////////////////////////
        $("#guardar").click(function (event) {
            if ($("#idRequerimientoUsuario").val() == "")
            {
                mensaje("Proporcione id de usuario.");
                return;
            }

            if ($("#nombre").val() == "")
            {
                mensaje("Proporcione nombre.");
                return;
            }
            //Validar que el id de usuario no exista
            event.preventDefault();
            msj = '';
            var text = "";
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/requerimientos/validaGuardar",
                type: "POST",
                data: {idproyecto: $("#idProyecto").val(), idusuario: $("#idRequerimientoUsuario").val(), idProyectoOri: 0}
            }).done(function (data) {
                msj = data;
                if (msj != '')
                {
                    mensaje("El Id de usuario ya existe, proporcione uno distinto.");
                    return;
                }
                else //armar el json para guardar
                {
                    alert('entro');
                    text = armarJson();
                    alert(text);
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/requerimientos/guardar",
                        type: "POST",
                        data: {jsonGuardar: text, nuevo : 1}
                    }).done(function (data) {
                        alert('despues');
                        if (data == 'No')
                        {
                            mensaje("No se pudo insertar el requerimiento.");
                        }
                        else
                        {
                            window.location.href = '<?php echo base_url(); ?>index.php/requerimientos';
                        }
                    }).fail(function (jqXHR, textStatus) {
                    });
                }
            }).fail(function (jqXHR, textStatus) {
            });
        });

        function armarJson()
        {
            var text = "";
            var atributos = atributosSeleccionados();
            var actividades = actividadesSeleccionadas(0, 1);
            var artefactos = artefactosSeleccionados(0, 1);
            var peticiones = peticionesSeleccionadas(0, 1);
            if (atributos == "")
                atributos = '"atributos":""';
            else
                atributos = '"atributos":' + atributos;

            if (actividades == "")
                actividades = '"actividades":""';
            else
                actividades = '"actividades":' + actividades;

            if (artefactos == "")
                artefactos = '"artefactos":""';
            else
                artefactos = '"artefactos":' + artefactos;

            if (peticiones == "")
                peticiones = '"peticiones":""';
            else
                peticiones = '"peticiones":' + peticiones;
            text = '{'
                    + '"idUsuario":"' + $("#idRequerimientoUsuario").val() + '",'
                    + '"idProyecto":' + $("#idProyecto").val() + ','
                    + '"nombre":"' + $("#nombre").val() + '",'
                    + '"idTipo":' + $("#idTipo").val() + ','
                    + '"idPrioridad":' + $("#idPrioridad").val() + ','
                    + '"idEstatus":1,'
                    + '"precondicion":"' + $("#precondicion").val() + '",'
                    + '"postcondicion":"' + $("#postcondicion").val() + '",'
                    + '"descripcionCorta":"' + $("#descripcionCorta").val() + '",'
                    + '"descripcionDetallada":"' + $("#descripcionDetallada").val() + '",'
                    + atributos + ','
                    + peticiones + ','
                    + artefactos + ','
                    + actividades
                    + '}';

            //var ob = JSON.parse(text);
            return text;
        }

        function atributosSeleccionados()
        {
            atributos = '';
            var table = document.getElementById('atributos');
            var inputs = table.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == 'checkbox' && inputs[i].checked == 1) {
                    if (atributos == '')
                        atributos = '{"id":' + inputs[i].value + '}';
                    else
                        atributos = atributos + ',{"id":' + inputs[i].value + '}';
                }
            }
            if (atributos != "")
                atributos = "[" + atributos + "]";
            return atributos;
        }
////////Termina guardar////////////////////
        $("#hrsReales").keydown(function (e) {             // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                            (e.keyCode == 65 && e.ctrlKey === true) || // Allow: Ctrl+C
                            (e.keyCode == 67 && e.ctrlKey === true) || // Allow: Ctrl+X
                            (e.keyCode == 88 && e.ctrlKey === true) ||
                            // Allow: home, end, left, right
                                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
    });
</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Requerimientos</h2>
    </header>
    <div id="mensaje" class="alert alert-danger" role="alert" hidden></div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <section class="panel panel-transparent">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Acciones</h2>
                    </header>
                    <div class="panel-body">
                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="guardar" id="guardar">
                            <i class="glyphicon glyphicon-floppy-saved"></i> Guardar</button>
                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="limpiar" id="limpiar">
                            <i class="glyphicon glyphicon-file"></i> Limpiar</button>
                        <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/requerimientos'">
                            <i class="glyphicon glyphicon-arrow-left"></i> Atrás</button>
                    </div>
                </section>
            </div>
        </div>
        <!--<form id="form" action="http://preview.oklerthemes.com/porto-admin/1.4.1/forms-validation.html" class="form-horizontal">-->
        <div class="tabs">
            <ul class="nav nav-tabs nav-justified">
                <li class="active">
                    <a href="#general" data-toggle="tab" class="text-center"><i class="fa fa-star"></i> General</a>
                </li>
                <li>
                    <a href="#captura" data-toggle="tab" class="text-center">Captura</a>
                </li>
                <li>
                    <a href="#detalle" data-toggle="tab" class="text-center">Información extra</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="general" class="tab-pane active">
                    <!--Datos generales del requerimiento--> 
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class="panel-title">Datos requerimiento</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Id usuario <span class="required">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" name="idRequerimientoUsuario" class="form-control" maxlength="10"
                                                   placeholder="ej.: 01-R0001" id="idRequerimientoUsuario"
                                                   <?php if (!empty($requerimiento['idRequerimientoUsuario'])) {
                                                       ?> value="<?= $requerimiento['idRequerimientoUsuario'] ?>" <?php }
                                                   ?>
                                                   required/>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <label class="col-sm-2 control-label">Tipo de requerimiento <span class="required">*</span></label>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($requerimiento['idTipo'])) {
                                                llenaComboTipoRequerimiento($requerimiento['idTipo'], 0);
                                            } else {
                                                llenaComboTipoRequerimiento('', 0);
                                            }
                                            ?>          
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Proyecto </label>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($requerimiento['idProyecto'])) {
                                                llenaComboProyectos($requerimiento['idProyecto']);
                                            } else {
                                                llenaComboProyectos('');
                                            }
                                            ?>          
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <label class="col-sm-2 control-label">Prioridad <span class="required">*</span></label>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($requerimiento['idPrioridad'])) {
                                                llenaComboPrioridad($requerimiento['idPrioridad'], 0);
                                            } else {
                                                llenaComboPrioridad('', 0);
                                            }
                                            ?>          
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Nombre <span class="required">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" id="nombre" name="nombre" class="form-control" maxlength="30"
                                                   placeholder="ej.: Requerimiento alta usuarios"
                                                   <?php if (!empty($requerimiento['nombre'])) {
                                                       ?> value="<?= $requerimiento['nombre'] ?>" <?php }
                                                   ?>
                                                   required/>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <label class="col-sm-2 control-label">Estatus </label>
                                        <label class="col-sm-2 control-label" style="color: green;font-size: 15px;font-weight: bold;">Activo </label>
                                        <input type="hidden" name="estatus" value="1" />
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <!--Atributos-->

                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class="panel-title">Atributos</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="atributos" class="table mb-none">
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th>
                                                    <th>Valor</th>
                                                    <th>Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($atributos)) {
                                                    foreach ($atributos as $u):
                                                        ?>
                                                        <tr>
                                                            <td class="hidden"><?= $u['idAtributo'] ?></td>
                                                            <td><?= $u['descripcion'] ?></td>
                                                            <td><?= $u['valor'] ?></td>
                                                            <?php if ($u['activo'] == 0) { ?>
                                                                <td><input type="checkbox" id="idAtributo" name="idAtributo[]" value="<?= $u['idAtributo'] ?>"/>Asignar</td>
                                                            <?php } else { ?>
                                                                <td><input type="checkbox" id="idAtributo" name="idAtributo[]" value="<?= $u['idAtributo'] ?>" checked=checked/>Asignar</td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                } else {
                                                    ?> <tr> <td> No hay información </td>  <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div id="captura" class="tab-pane">

                    <!--Cuerpo de los Requerimientos--> 
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class="panel-title">Captura de requerimiento</h2>
                                </header>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Precondición</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" name="precondicion" class="form-control" maxlength="1000"
                                                      placeholder="Proporcione precondición" id="precondicion"
                                                      rows="4" <?php if (!empty($requerimiento['precondicion'])) {
                                                    ?> value="<?= $requerimiento['precondicion'] ?>" <?php }
                                                ?> ><?php if (!empty($requerimiento['precondicion'])) {
                                                    ?>value="<?= $requerimiento['precondicion'] ?>"<?php }
                                                ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Postcondición</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" id="postcondicion" class="form-control" maxlength="1000"
                                                      placeholder="Proporcione postcondición" name="postcondicion" 
                                                      rows="4" <?php if (!empty($requerimiento['postcondicion'])) {
                                                    ?> value="<?= $requerimiento['postcondicion'] ?>" <?php }
                                                ?> ><?php if (!empty($requerimiento['postcondicion'])) {
                                                    ?>value="<?= $requerimiento['postcondicion'] ?>"<?php }
                                                ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Descripción corta</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" name="descripcionCorta" class="form-control" maxlength="1000"
                                                      placeholder="Proporcione descripción corta" id="descripcionCorta"
                                                      rows="4" <?php if (!empty($requerimiento['descripcionCorta'])) {
                                                    ?> value="<?= $requerimiento['descripcionCorta'] ?>" <?php }
                                                ?> ><?php if (!empty($requerimiento['descripcionCorta'])) {
                                                    ?>value="<?= $requerimiento['descripcionCorta'] ?>"<?php }
                                                ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Descripción detallada</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" name="descripcionDetallada" class="form-control" maxlength="10000"
                                                      placeholder="Proporcione descripción detallada" id="descripcionDetallada"
                                                      rows="13" <?php if (!empty($requerimiento['descripcionDetallada'])) {
                                                    ?> value="<?= $requerimiento['descripcionDetallada'] ?>" <?php }
                                                ?> ><?php if (!empty($requerimiento['descripcionDetallada'])) {
                                                    ?>value="<?= $requerimiento['descripcionDetallada'] ?>"<?php }
                                                ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                </div>

                <div id="detalle" class="tab-pane">

                    <!--Peticiones y artefactos-->
                    <div class="row">
                        <div class="col-md-6">
                            <section class="panel">
                                <header class="panel-heading">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class="panel-title">Peticiones</h2>
                                </header>
                                <div class="panel-body">
                                    <div>
                                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="agregarPeticion" id="agregarPeticion">
                                            <i class="glyphicon glyphicon-file"></i>Agregar</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="peticiones" class="table mb-none">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Quitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($peticiones)) {
                                                    foreach ($peticiones as $u):
                                                        ?>
                                                        <tr id="<?= "row-" . $u['idPeticion'] ?>">
                                                            <td class="hidden"><?= $u['idPeticion'] ?></td>
                                                            <td><?= $u['nombre'] ?></td>
                                                            <td><?= $u['descripcion'] ?></td>
                                                            <td class="actions">
                                                                <a class="show-delete-modal-peticion" href="#" data-idpeticion="<?= $u['idPeticion'] ?>" data-toggle="modal" data-target="#modal-eliminar-peticion">
                                                                    <i class="fa fa-trash-o"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                } else {
                                                    ?> <tr> <td> No hay información </td>  <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-md-6">
                            <section class="panel">
                                <header class="panel-heading">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class="panel-title">Artefactos</h2>
                                </header>
                                <div class="panel-body">
                                    <div>
                                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="agregarArtefacto" id="agregarArtefacto">
                                            <i class="glyphicon glyphicon-file"></i>Agregar</button>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="artefactos" class="table mb-none">
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th>
                                                    <th>Quitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($artefactos)) {
                                                    foreach ($artefactos as $u):
                                                        ?>
                                                        <tr id="<?= "row-" . $u['idArtefacto'] ?>">
                                                            <td class="hidden"><?= $u['idArtefacto'] ?></td>
                                                            <td><?= $u['descripcion'] ?></td>
                                                            <td class="actions">
                                                                <a class="show-delete-modal-artefacto" href="#" data-idartefacto="<?= $u['idArtefacto'] ?>" data-toggle="modal" data-target="#modal-eliminar-artefacto">
                                                                    <i class="fa fa-trash-o"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                } else {
                                                    ?> <tr> <td> No hay información </td>  <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <!--Actividades-->

                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class="panel-title">Actividades</h2>
                                </header>
                                <div class="panel-body">
                                    <div>
                                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="agregarActividad" id="agregarActividad">
                                            <i class="glyphicon glyphicon-file"></i>Agregar</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="actividades" class="table mb-none">
                                            <thead>
                                                <tr>
                                                    <th>Actividad</th>
                                                    <th>Duración Hrs.</th>
                                                    <th>Hrs. Reales</th>
                                                    <th>Responsable</th>
                                                    <th>Estatus</th>
                                                    <th>Quitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($actividades)) {
                                                    foreach ($actividades as $u):
                                                        ?>
                                                        <tr id="<?= "row-" . $u['idActividad'] ?>">
                                                            <td class="hidden"><input type="hidden" name="estatus" value="<?= $u['idActividad'] ?>" /><?= $u['idActividad'] ?></td>
                                                            <td><?= $u['descripcion'] ?></td>
                                                            <td><?= $u['duracionHrs'] ?></td>
                                                            <td><input type="text" id="hrsReales" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="hrsReales" class="form-control" maxlength="5" value="<?= $u['hrsReales'] ?>"/></td>
                                                            <td><input type="text" name="responsable" class="form-control" maxlength="100" value="<?= $u['responsable'] ?>"/></td>
                                                            <td><?= llenaComboEstatus("1", 'A'); ?></td>
                                                            <td class="actions">
                                                                <a class="show-delete-modal-actividad" href="#" data-idactividad="<?= $u['idActividad'] ?>" data-toggle="modal" data-target="#modal-eliminar-actividad">
                                                                    <i class="fa fa-trash-o"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                } else {
                                                    ?> <tr> <td> No hay información </td>  <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--</form>-->
        <div id="mensaje2" class="alert alert-danger" role="alert" hidden></div>
    </div>

    <!--///// SECCION DE MODALES //////-->
    <!--Delete peticion-->
    <div class="modal fade" id="modal-eliminar-peticion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar quitar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea quitar la petición?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="confirm-delete-peticion"  type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--Modal peticiones-->
    <div class="modal fade" id="modal-peticiones">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <header class="panel-heading">
                        <h2 class="panel-title">Añadir peticiones</h2>
                    </header>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="modalPeticiones" class="table mb-none">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Añadir</th>
                                </tr>
                            </thead>
                            <!--Codigo JavaScript-->
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="confirm-peticionModal"  type="button" class="btn btn-primary">Añadir</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!--Delete artefactos-->
    <div class="modal fade" id="modal-eliminar-artefacto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar quitar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea quitar el artefacto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="confirm-delete-artefacto"  type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--Modal artefactos-->
    <div class="modal fade" id="modal-artefactos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <header class="panel-heading">
                        <h2 class="panel-title">Añadir artefactos</h2>
                    </header>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="modalArtefactos" class="table mb-none">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Añadir</th>
                                </tr>
                            </thead>
                            <!--Codigo JavaScript-->
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="confirm-artefactoModal"  type="button" class="btn btn-primary">Añadir</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--Delete actividad-->
    <div class="modal fade" id="modal-eliminar-actividad">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar quitar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea quitar la actividad?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="confirm-delete-actividad"  type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--Modal actividades-->
    <div class="modal fade" id="modal-actividades">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <header class="panel-heading">
                        <h2 class="panel-title">Añadir actividades</h2>
                    </header>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="modalActividad" class="table mb-none">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Añadir</th>
                                </tr>
                            </thead>
                            <!--Codigo JavaScript-->
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="confirm-actividadModal"  type="button" class="btn btn-primary">Añadir</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</section>


<?php $this->load->view('plantilla/vistaPie'); ?>