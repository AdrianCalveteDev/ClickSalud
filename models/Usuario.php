<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasBaseDatos = ['id', 'nombre', 'apellido', 'email', 'contrasena_hash', 'rol', 'creado_en', 'actualizado_en'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $contrasena_hash;
    public $repetirContrasena;
    public $rol;
    public $creado_en;
    public $actualizado_en;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->contrasena_hash = $args['contrasena_hash'] ?? '';
        $this->repetirContrasena = $args['repetirContrasena'] ?? '';
        // Si un usuario crea una cuenta por defecto se le asigna el rol usuario
        $this->rol = 'usuario';
        $this->creado_en = date('Y-m-d H:i:s') ?? '';
        $this->actualizado_en = date('Y-m-d H:i:s') ?? '';
    }

    public function validar()
    {   
        if(!$this->nombre){
            self::$errores[] = 'Debes poner un nombre';
        }
        if(!$this->contrasena_hash){
            self::$errores[] = 'El apellido es obligatorio';
        }
        if(!$this->email){
            self::$errores[] = 'El email es obligatorio';
        }
        if(!$this->contrasena_hash){
            self::$errores[] = 'La contraseña es obligatoria';
        } else {
            // Validación de la fortaleza de la contraseña
            if (strlen($this->contrasena_hash) < 8) {
                self::$errores[] = 'La contraseña debe tener al menos 8 caracteres.';
            }
            if (!preg_match('/[A-Z]/', $this->contrasena_hash)) {
                self::$errores[] = 'La contraseña debe contener al menos una letra mayúscula.';
            }
            if (!preg_match('/[a-z]/', $this->contrasena_hash)) {
                self::$errores[] = 'La contraseña debe contener al menos una letra minúscula.';
            }
            if (!preg_match('/[0-9]/', $this->contrasena_hash)) {
                self::$errores[] = 'La contraseña debe contener al menos un número.';
            }
            if (!preg_match('/[\W]/', $this->contrasena_hash)) { // \W = carácter no alfanumérico
                self::$errores[] = 'La contraseña debe contener al menos un carácter especial.';
            }
        }
        // Validamos que las dos contraseñas introducidas por el usuario coincidan para evitar que se equivoque
        if ($this->contrasena_hash !== $this->repetirContrasena) {
            self::$errores[] = 'Las contraseñas no coinciden.';
        }

        return self::$errores;
    }

    public function usuarioExiste(){
        // Verificar que un usuario existe con una query hacia su email
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$baseDatos->query($query);

        if($resultado->num_rows){
            self::$errores[] = 'Este usuario ya tiene una cuenta en ClickSalud con este correo.';
            return;
        }

        return $resultado;
    }
}