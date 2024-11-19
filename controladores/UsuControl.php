<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/modelos/Usu.php';

    class UsuControl{
        private $db;
        private $user;

        public function __construct($db){
            $this->db = $db;
            $this->user = new Usu($this->db);
        }

        public function create($nombre, $contra, $correo, $rol){
            $this->user->nombre = $nombre;
            $this->user->contra = $contra;
            $this->user->correo = $correo;
            $this->user->rol = $rol;
            return $this->user->create();
        }

        public function request(){
            return $this->user->request();
        }
        public function requestById($id){
            return $this->user->requestById($id);
        }
        public function update($id, $nombre, $correo, $rol, $contra = null) {
            if (!is_numeric($id) || $id <= 0) {
                return "ID inválido para actualizar el usuario.";
            }
        
            if ($this->user->update($id, $nombre, $correo, $rol, $contra)) {
                return "Usuario actualizado correctamente.";
            } else {
                return "Error al actualizar el usuario.";
            }
        }  

        public function delete($id) {
            if (!is_numeric($id) || $id <= 0) {
                return "ID inválido para eliminar el usuario.";
            }
    
            if ($this->user->delete($id)) {
                return "Usuario eliminado correctamente.";
            } else {
                return "Error al eliminar el usuario.";
            }
        }

        public function login($correo, $contra){
            $this->user->correo = $correo;
            $this->user->contra = $contra;
            $userData = $this->user->login($correo);
            
            if($userData !== false){
                if($userData['contraseña'] === $contra){
                    $_SESSION['id'] = $userData['id'];
                    $_SESSION['nombre'] = $userData['nombre'];
                    $_SESSION['rol'] = $userData['rol'];
                    return true;
                }
            }
            return false;
        }
    }
?>