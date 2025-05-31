<?php

namespace Model;

class Admin extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasBaseDatos = ['id', 'nombre', 'apellido', 'email', 'contrasena_hash', 'rol'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $contrasena_hash;
    public $rol;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->contrasena_hash = $args['contrasena_hash'] ?? '';
        $this->rol = $args['rol'] ?? '';
    }

    public function validar()
    {
        if(!$this->email){
            self::$errores[] = 'El email es obligatorio';
        }
        if(!$this->contrasena_hash){
            self::$errores[] = 'La contraseña es obligatoria';
        }

        return self::$errores;
    }

    public function usuarioExiste(){
        // Verificar que un usuario existe con una query hacia su email
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$baseDatos->query($query);

        if(!$resultado->num_rows){
            self::$errores[] = 'El usuario no existe.';
            return;
        }

        return $resultado;
    }

    public function comprobarContrasena($resultado){
        $usuario = $resultado->fetch_object();

        // Comprobamos que la contraseña almacenada en base de datos coincide con la introducida por el usuario en el formualrio
        $autenticado = password_verify($this->contrasena_hash, $usuario->contrasena_hash);

        // Si no coinciden las contraseña el valor de autenticado es false y le adjuntamos al usuario el mensaje de error por contraseña incorrecta
        if(!$autenticado){
            self::$errores[] = 'Contraseña incorrecta';
            return false;
        } else {
            // Si el usuario existe, almacenamos el rol del usuario, su id y su nombre
            $this->rol = $usuario->rol;
            $this->id = $usuario->id;
            $this->nombre = $usuario->nombre;
            $this->apellido = $usuario->apellido;
            return true;
        }
    }

    public function autenticar(){
        // Iniciamos la sesión
        session_start();

        // Llenamos el array con los valores que necesitamos
        $_SESSION['login'] = true;
        $_SESSION['usuario_id'] = $this->id;
        $_SESSION['usuario'] = $this->email;
        $_SESSION['rol'] = $this->rol;
        $_SESSION['nombre'] = $this->nombre;

        // Si el usuario tiene rol de administrador le redirigimos al panel de administración
        if($this->rol === 'admin'){
            header('Location: /admin');
            // Y si tiene el rol de usuario le redirigiremos al panel de citas
        } elseif ($this->rol === 'usuario') {
            header('Location: /citas/misCitas');
        } 
    }
}