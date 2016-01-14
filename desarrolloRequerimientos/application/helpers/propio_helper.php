<?php

function llenaCombo() {
    $CI = get_instance();
    $CI->load->model('Modelorol');
    $roles = $CI->Modelorol->traerRoles();

    $options = array();
    foreach ($roles as $row) {//$key => $value)
        $options += array($row["idRol"] => $row["descripcion"]);
    }
    $js = 'class="form-control" id="rol"';
    echo form_dropdown('rol', $options, '1', $js);
}

function llenaComboEstatus($idEstatus,$filtro) {
    
    $CI = get_instance();
    $CI->load->model('Modeloestatus');
    $estatus = $CI->Modeloestatus->get_estatusCombo($filtro);
    $options = array();
    foreach ($estatus as $row) {//$key => $value)
        $options += array($row["idEstatus"] => $row["descripcion"]);
    }
    $js = 'class="form-control" id="estatus"';
    echo form_dropdown('estatus', $options, $idEstatus, $js);
}

function llenaComboEstatusConsultaRequisitos($idEstatus,$filtro) {
    
    $CI = get_instance();
    $CI->load->model('Modeloestatus');
    $estatus = $CI->Modeloestatus->get_estatusCombo($filtro);
    $options = array(""=>"Todos");
    foreach ($estatus as $row) {//$key => $value)
        $options += array($row["idEstatus"] => $row["descripcion"]);
    }
    $js = 'class="form-control" id="estatus"';
    echo form_dropdown('estatus', $options, $idEstatus, $js);
}

function llenaComboGlosario($idGlosario) {
    $CI = get_instance();
    $CI->load->model('Modeloglosario');
    $glosarios = $CI->Modeloglosario->get_glosarioCombo();
    $options = array();
    foreach ($glosarios as $row) {//$key => $value)
        $options += array($row["idGlosario"] => $row["nombre"]);
    }
    $js = 'class="form-control" id="idGlosario"';
    echo form_dropdown('idGlosario', $options, $idGlosario, $js);
}

function llenaComboProyectos($idProyecto) {
    $CI = get_instance();
    $CI->load->model('Modeloproyecto');
    $proyectos = $CI->Modeloproyecto->get_proyectos_combo();
    $options = array();
    foreach ($proyectos as $row) {//$key => $value)
        $options += array($row["idProyecto"] => $row["nombre"]);
    }
    $js = 'class="form-control" id="idProyecto"';
    echo form_dropdown('idProyecto', $options, $idProyecto, $js);
}

function llenaComboTipoRequerimiento($idTipo, $todos) {
    $CI = get_instance();
    $CI->load->model('Modelotiporequerimiento');
    $tipos = $CI->Modelotiporequerimiento->get_tipos_requerimientos();
    $options = array();
    if ($todos==1)
        $options += array(''=>"Todos");
    foreach ($tipos as $row) {//$key => $value)
        $options += array($row["idTipo"] => $row["descripcion"]);
    }
    $js = 'class="form-control" id="idTipo"';
    echo form_dropdown('idTipo', $options, $idTipo, $js);
}

function llenaComboPrioridad($idPrioridad, $todos) {
    $CI = get_instance();
    $CI->load->model('Modeloprioridad');
    $prioridad = $CI->Modeloprioridad->get_prioridades();
    $options = array();
    if ($todos==1)
        $options += array(''=>"Todos");     
    foreach ($prioridad as $row) {//$key => $value)
        $options += array($row["idPrioridad"] => $row["descripcion"]);
    }
    $js = 'class="form-control" id="idPrioridad"';
    echo form_dropdown('idPrioridad', $options, $idPrioridad, $js);
}

function llenaComboCasoPrueba($idCasoPrueba) {
    $CI = get_instance();
    $CI->load->model('Modelocasoprueba');
    $cp = $CI->Modelocasoprueba->get_casosPruebas();
    $options = array();
    foreach ($cp as $row) {//$key => $value)
        $options += array($row["idCasoPrueba"] => $row["descripcion"]);
    }
    $js = 'class="form-control" id="idCasoPrueba"';
    echo form_dropdown('idCasoPrueba', $options, $idCasoPrueba, $js);
}

function llenaModulos($idModulo) {
    $CI = get_instance();
    $CI->load->model('Modelomodulo');
    $modulos = $CI->Modelomodulo->get_modulos();

    $options = array();
    foreach ($modulos as $row) {//$key => $value)
        $options += array($row["idModulo"] => $row["descripcion"]);
    }
    $js = 'class="form-control" id="idModulo"';
    echo form_dropdown('idModulo', $options, $idModulo, $js);
}

function llenaRolesEditar($rol) {
    $CI = get_instance();
    $CI->load->model('Modelorol');
    $roles = $CI->Modelorol->traerRoles();

    $options = array();
    foreach ($roles as $row) {//$key => $value)
        $options += array($row["idRol"] => $row["descripcion"]);
    }
    $js = 'class="form-control" multiple="multiple" data-plugin-multiselect id="rol" required';
    echo form_multiselect('rol[]', $options, $rol, $js);
}

function is_logged_in() {
    // Get current CodeIgniter instance
    $CI = get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('idUsuario');
    if (!isset($user)) {
        return false;
    } else {
        return true;
    }
}

function sesionValor($valor) {
    $CI = get_instance();
    $user = '';
    if ($valor == 'usuarioNombre') {
        $user = $CI->session->userdata('nombre');
        ;
    }
    if ($valor == 'rolNombre') {
        $user = $CI->session->userdata('descRol');
        ;
    }
    return $user;
}

function logout() {
    $CI = get_instance();
    $CI->session->sess_destroy();
    redirect(base_url() . 'index.php/login');
}

/////////////MEEENUU///
function menu() {
    $CI = get_instance();
    //obtener el rol del usuario logeado
    $session_rol = $CI->session->userdata('idRol');
    $CI->load->model('Modelorolopcion');
    //obtener las opciones a las que tiene permiso el rol
    $rolOpciones = $CI->Modelorolopcion->get_rol_opciones_permiso($session_rol);
    if (!empty($rolOpciones)) {
        $newMenu = '';
        $modulo = 0;
        $entro = 0;
        $base=base_url();
        foreach ($rolOpciones as $u):
            if ($modulo != $u['idModulo']) {
                //cerrar cambio de modulo
                if ($entro == 1) {
                    $entro = 0;
                    $newMenu .= '</ul> </li>';
                }
                $modulo = $u['idModulo'];
                $newMenu .= '<li class="nav-parent">'
                        . '<a>'
                        . '<i class="' . $u['nombreIcono'] . '" aria-hidden="true"></i>'
                        . '<span>' . $u['descModulo'] . '</span>'
                        . '</a>'
                        . '<ul class="nav nav-children">';
                $entro = 1;
            }
            //opciones
            $newMenu .= ' <li>'
                    . '<a href="' . $base . 'index.php/' . $u['nombreControlador'] . '">' . $u['descOpcion'] . '</a>'
                    . '</li>';

        endforeach;
         $newMenu .= '</ul> </li>';
         echo $newMenu;
    }
}
?>