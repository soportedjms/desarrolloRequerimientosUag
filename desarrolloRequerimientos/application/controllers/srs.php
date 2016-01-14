<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SRS extends CI_Controller {

    public function __constructor() {
        parent::__constructor();
    }

    // this is the home page
    public function index() {
        if (!is_logged_in()) {
            redirect(base_url() . 'index.php/login');
        }
        if ($this->input->post('nuevo')) {
            $this->nuevo();
        } else {
            $this->todosSRS('1');
        }
    }

    public function consulta() {
        $proyecto = $_POST['idProyecto'];
        $this->todosSRS($proyecto);
    }

    public function nuevo() {
        $this->load->view('srs/nuevo');
    }

    public function guardarNuevo() {
        $datos = array("idProyecto" => $_POST['idProyecto'], "proposito" => $_POST['proposito'],
            "alcance" => $_POST['alcance'], "objetivo" => $_POST['objetivo'], "descripcion" => $_POST['descripcion']);
        $proyecto = $_POST['idProyecto'];
        //Traer linea base para el proyecto seleccionado, si no existe una aprobda, mandar mensaje de error
        $this->load->model('Modelolineabase');
        $lineBase = $this->Modelolineabase->get_ultimaLineaBaseAprobada($proyecto);
        if (empty($lineBase)) {
            $error_msg = "No existe línea de base aprobada para el proyecto seleccionado.";
            $data = array("mensaje" => $error_msg, "datos" => $datos);
            $this->load->view('srs/nuevo', $data);
        } else {
            $datos["idLineaBase"] = $lineBase["idLineaBase"];
            $datos["activo"] = 1;
            $datos["fechaCreacion"] = date('Y-m-d H:i:s');
            $datos["usuarioCreacion"] = $this->session->userdata('idUsuario');
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modelosrs');
            if (empty($this->Modelosrs->generarSRS($datos))) {
                $error_msg = "No se pudo generar la línea base.";
                $data = array("mensaje" => $error_msg, "datos" => $datos);
                $this->load->view('srs/nuevo', $data);
            } else {
                $this->index();
            }
        }
    }

    public function editar($id, $proyecto) {
        $this->load->model('Modelolineabase');
        $lineaBase = $this->Modelolineabase->get_LineasBase($proyecto, $id);

        $data = array("datos" => $lineaBase);
        $this->load->view('lineasBase/editar', $data);
    }

    public function guardarEditar() {
        $estaAprobada = 0;
        if (isset($_POST['estaAprobada']))
            $estaAprobada = 1;
        $datos = array("idProyecto" => $_POST['idProyecto'], "nombre" => $_POST['nombre'], "descripcion" => $_POST['descripcion'],
            "estatus" => $_POST['estatus'], "idLineaBase" => $_POST['idLineaBase'], "estaAprobada" => $estaAprobada);
        //Editar
        $this->load->model('Modelolineabase');
        if (empty($this->Modelolineabase->editarLineaBase($datos))) {
            $error_msg = "No se pudo actualizar la línea base.";
            $data = array("mensaje" => $error_msg, "datos" => $datos);
            $this->load->view('lineasBase/editar', $data);
        } else {
            $this->index();
        }
    }

    public function detalle($idsrs, $linea, $proyecto) {
        $this->load->model('Modelosrs');
        $srs = $this->Modelosrs->get_SRS($proyecto, $linea, $idsrs);
        $peticiones = $this->Modelosrs->getSRSPeticiones($proyecto, $linea, $idsrs); //peticiones asignadas a los requisitos de la linea base
//        var_dump($peticiones);
//        return;
        $artefactos = $this->Modelosrs->getSRSArtefactos($proyecto, $linea, $idsrs); //artefactos asignados a los requisitos de la linea base
        $this->load->model('Modelodefinicion');
        $definiciones = $this->Modelodefinicion->get_definicionesLineaBase($proyecto, $linea);
        $this->load->model('Modelorequerimiento');
        $requerimientos = $this->Modelorequerimiento->get_requerimientosLineaBase($proyecto, $linea);
        $data = array("datos" => $srs, "definiciones" => $definiciones, "requerimientos" => $requerimientos,
            "artefactos" => $artefactos, "peticiones" => $peticiones);
        $this->load->view('srs/detalle', $data);
    }

    public function exportar($idsrs, $proyecto, $linea) {
        $this->load->model('Modelosrs');
        $srs = $this->Modelosrs->get_SRS($proyecto, $linea, $idsrs);
        $peticiones = $this->Modelosrs->getSRSPeticiones($proyecto, $linea, $idsrs); //peticiones asignadas a los requisitos de la linea base
        $artefactos = $this->Modelosrs->getSRSArtefactos($proyecto, $linea, $idsrs); //artefactos asignados a los requisitos de la linea base
        $this->load->model('Modelodefinicion');
        $definiciones = $this->Modelodefinicion->get_definicionesLineaBase($proyecto, $linea);
        $this->load->model('Modelorequerimiento');
        $requerimientos = $this->Modelorequerimiento->get_requerimientosLineaBase($proyecto, $linea);


        $this->load->library('Pdf');
        $this->pdf = new Pdf();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("SRS-" . $idsrs);
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200, 200, 200);
        $this->pdf->SetAutoPageBreak(true, 20);

        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 9);

        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */

        //Añadir información del SRS
        $this->pdf->Cell(180, 7, "GENERAL", 'TBLR', 0, 'C', '1');
        $this->pdf->Ln(7);
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'ID SRS:', '', 0, 'R', '0');
        $this->pdf->Cell(15, 7, $idsrs, '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'PROYECTO:', '', 0, 'R', '0');
        $this->pdf->Cell(100, 7, $srs['nombreProyecto'], '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'LINEA BASE:', '', 0, 'R', '0');
        $this->pdf->Cell(100, 7, $srs['nombreLineaBase'], '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'PROPOSITO:', '', 0, 'R', '0');
        $this->pdf->Cell(300, 7, $srs['proposito'], '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'ALCANCE:', '', 0, 'R', '0');
        $this->pdf->Cell(500, 7, $srs['alcance'], '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'OBJETIVO:', '', 0, 'R', '0');
        $this->pdf->Cell(500, 7, $srs['objetivo'], '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'DESCRIPCION:', '', 0, 'R', '0');
        $this->pdf->Cell(500, 7, $srs['descripcion'], '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'FECHA CREACION:', '', 0, 'R', '0');
        $this->pdf->Cell(500, 7, $srs['fechaCreacion'], '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Cell(30, 7, 'USUARIO CREACION:', '', 0, 'R', '0');
        $this->pdf->Cell(500, 7, $srs['nombreUsrCreacion'], '', 0, 'L', '0');
        $this->pdf->Ln(7);
        $this->pdf->Ln(7);
        //DEFINICIONES
        $this->pdf->Cell(180, 7, "GLOSARIO Y DEFINICIONES", 'TBLR', 0, 'C', '1');
        $this->pdf->Ln(7);
        $this->pdf->Ln(7);

        foreach ($definiciones as $definicion) {
            $this->pdf->Cell(30, 5, 'NOMBRE', '', 0, 'C', '1');
            $this->pdf->Cell(200, 5, $definicion['nombreGlosario'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'PALABRA', '', 0, 'C', '1');
            $this->pdf->Cell(200, 5, $definicion['palabra'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'DEFINICION', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $definicion['definicion'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Ln(5);
        }

        //PETICIONES
        $this->pdf->Cell(180, 7, "PETICIONES", 'TBLR', 0, 'C', '1');
        $this->pdf->Ln(7);
        $this->pdf->Ln(7);

        foreach ($peticiones as $peticion) {
            $this->pdf->Cell(30, 5, 'ID', '', 0, 'C', '1');
            $this->pdf->Cell(200, 5, $peticion['idPeticion'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'NOMBRE', '', 0, 'C', '1');
            $this->pdf->Cell(200, 5, $peticion['nombre'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'DESCRIPCION', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $peticion['descripcion'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Ln(5);
        }

        //ARTEFACTOS
        $this->pdf->Cell(180, 7, "ARTEFACTOS", 'TBLR', 0, 'C', '1');
        $this->pdf->Ln(7);
        $this->pdf->Ln(7);

        foreach ($artefactos as $artefacto) {
            $this->pdf->Cell(30, 5, 'ID', '', 0, 'C', '1');
            $this->pdf->Cell(200, 5, $artefacto['idArtefacto'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'DESCRIPCION', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $artefacto['descripcion'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Ln(5);
        }

        //REQUERIMIENTOS
        $this->pdf->Cell(180, 7, "REQUERIMIENTOS", 'TBLR', 0, 'C', '1');
        $this->pdf->Ln(7);
        $this->pdf->Ln(7);

        foreach ($requerimientos as $req) {
            $this->pdf->Cell(30, 5, 'ID USUARIO', '', 0, 'C', '1');
            $this->pdf->Cell(200, 5, $req['idRequerimientoUsuario'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'NOMBRE', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $req['nombre'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'DESCRIPCION', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $req['descripcionCorta'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'TIPO', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $req['descTipo'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'PRIORIDAD', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $req['descPrioridad'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'ESTATUS', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $req['descEstatus'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Cell(30, 5, 'FECHA', '', 0, 'C', '1');
            $this->pdf->Cell(400, 5, $req['fecha'], '', 0, 'L', 0);
            $this->pdf->Ln(7);
            $this->pdf->Ln(5);
        }

        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("SRS-" . $idsrs . ".pdf", 'D');
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosSRS($proyecto) {
        $consulta = array("idProyecto" => $proyecto);
        $this->load->model('Modelosrs');
        $srs = $this->Modelosrs->get_SRS($proyecto, '', '');
        $data = array("srs" => $srs, "consulta" => $consulta);
        $this->load->view('srs/lista', $data);
    }

}
