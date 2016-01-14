<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modelousuario extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function validaUsuarioSesion($usuario, $password, $rol) {
        $query = $this->db->query("SELECT u.idUsuario, rol.idRol,u.nombre,u.usuario,
                rol.descripcion descRol, u.correo, u.esAdministrador
                FROM usuario u
                inner join usuario_Rol on u.idUsuario=usuario_Rol.idUsuario
                INNER JOIN rol ON usuario_rol.idRol=rol.idRol
                where u.usuario=? and u.password=? and usuario_Rol.idRol=? LIMIT 1", array($usuario, $password, $rol));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function get_usuarios() {

        $query = $this->db->query("SELECT * FROM usuario order by usuario");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_usuario($id) {

        $query = $this->db->query("SELECT *  FROM usuario
                where idUsuario=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function get_usuario_roles($id) {
        $query = $this->db->query("SELECT usuario_rol.idRol, rol.descripcion descRol  FROM usuario_rol
                inner join rol on rol.idRol=usuario_rol.idRol
                where usuario_rol.idUsuario=?", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return null;
        }
    }

    public function validaUsuario($usuario, $id) {
        if ($id != 0) { //es guardar editar, validar que el usuario no exista en otro rgistro diferente al que se esta modificando
            $query = $this->db->query("SELECT usuario FROM usuario
					where usuario=? AND idUsuario<>? LIMIT 1", array($usuario, $id));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        } else {
            $query = $this->db->query("SELECT usuario FROM usuario
					where usuario=? LIMIT 1", array($usuario));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        }
    }

    public function insertarUsuario($data) {
        try {
            $this->db->trans_begin();
            $user_data = array(
                "usuario" => $data['usuario'],
                "correo" => $data['email'],
                "password" => $data['password'],
                "nombre" => $data['nombre'],
                "esAdministrador" => $data['esAdmin']);

            $insert = $this->db->insert("usuario", $user_data);
            $insert_id = $this->db->insert_id();

            foreach ($data['roles'] as $r) {
                $user_rol = array("idUsuario" => $insert_id,
                    "idRol" => $r);
                $this->db->insert("usuario_rol", $user_rol);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
            }
            return true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return array("status" => false, "message" => $ex->getMessage());
        }
    }

    public function editarUsuario($data) {
        try {
            $user = $data['user'];
            $user_data = array(
                "usuario" => $user['usuario'],
                "correo" => $user['correo'],
                "password" => $user['password'],
                "nombre" => $user['nombre'],
                "esAdministrador" => $user['esAdministrador']);
            $this->db->trans_begin();
            $insert = $this->db->update("usuario", $user_data, array('idUsuario' => $user["idUsuario"]));
            //usuario rol
            $this->db->delete('usuario_rol', array('idUsuario' => $user["idUsuario"]));
            foreach ($data['roles'] as $r) {
                $user_rol = array("idUsuario" => $user["idUsuario"],
                    "idRol" => $r);
                $this->db->insert("usuario_rol", $user_rol);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
            }
            return true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return array("status" => false, "message" => $ex->getMessage());
        }
    }

    public function eliminarUsuario($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('usuario_rol', array('idUsuario' => $id));
            $this->db->delete('usuario', array('idUsuario' => $id));
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
            }
            return true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return array("status" => false, "message" => $ex->getMessage());
        }
    }
}

//    public function get_usuario($id) {
//        $query = $this->db->query("SELECT * FROM usuario WHERE id = ?", array($id));
//
//        if ($query->num_rows() > 0) {
//            $row = $query->row_array();
//            return $row;
//        } else {
//            return null;
//        }
//    }
//
//    public function eliminar_usuario($id) {
//        try {
//
//            $this->db->trans_begin();
//
//            $this->db->delete('comentarios', array('id_usuario' => $id));
//            $this->db->delete('usuario', array('id' => $id));
//
//            if ($this->db->trans_status() === FALSE) {
//                $this->db->trans_rollback();
//            } else {
//                $this->db->trans_commit();
//            }
//
//            return true;
//        } catch (Exception $ex) {
//            $this->db->trans_rollback();
//            return array("status" => false, "message" => $ex->getMessage());
//        }
//    }
//
//    public function editar_usuario($data, $cambiar) {
//
//        $user_data = array();
//
//        if ($cambiar) {
//            $user_data = array(
//                "id_rol" => $data["rol"],
//                "contrasena" => md5($data["pass1"]),
//                "nombre" => $data["name"],
//                "apellido" => $data["apellido"],
//                "nacimiento" => $data["date"],
//                "pais" => "México",
//                "ciudad" => "Guadalajara");
//        } else {
//            $user_data = array(
//                "id_rol" => $data["rol"],
//                "nombre" => $data["name"],
//                "apellido" => $data["apellido"],
//                "nacimiento" => $data["date"],
//                "pais" => "México",
//                "ciudad" => "Guadalajara");
//        }
//
//        $insert = $this->db->update("usuario", $user_data, array('id' => $data["id"]));
//
//        return $insert;
//    }