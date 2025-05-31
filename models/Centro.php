<?php

namespace Model;

class Centro extends ActiveRecord {
    protected static $tabla = 'centros';
    protected static $columnasBaseDatos = ['id', 'nombre', 'direccion', 'telefono', 'email', 'ciudad_id', 'creado_en', 'actualizado_en'];

    public $id;
    public $nombre;
    public $direccion;
    public $telefono;
    public $email;
    public $ciudad_id;
    public $creado_en;
    public $actualizado_en;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->ciudad_id = $args['ciudad_id'] ?? '';
        $this->creado_en = date('Y-m-d H:i:s');
        $this->actualizado_en = date('Y-m-d H:i:s');
    }

    public function validar() {
        if (!$this->nombre) {
            self::$errores[] = 'El nombre es obligatorio';
        }
        if (!$this->email) {
            self::$errores[] = 'El email es obligatorio';
        }
        return self::$errores;
    }
}
