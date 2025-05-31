<?php

namespace Model;

class Cita extends ActiveRecord {
    protected static $tabla = 'citas';
    protected static $columnasBaseDatos = ['id', 'usuario_id', 'servicio_id', 'especialista_id', 'centro_id', 'fecha_cita', 'hora_cita', 'estado', 'creado_en', 'actualizado_en', 'especialidad_id'];

    public $id;
    public $usuario_id;
    public $servicio_id;
    public $especialista_id;
    public $centro_id;
    public $fecha_cita;
    public $hora_cita;
    public $estado;
    public $creado_en;
    public $actualizado_en;
    public $especialidad_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? null;
        $this->servicio_id = $args['servicio_id'] ?? null;
        $this->especialista_id = $args['especialista_id'] ?? null;
        $this->centro_id = $args['centro_id'] ?? null;
        $this->fecha_cita = $args['fecha_cita'] ?? '';
        $this->hora_cita = $args['hora_cita'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->creado_en = date('Y-m-d H:i:s');
        $this->actualizado_en = date('Y-m-d H:i:s');
        $this->especialidad_id = $args['especialidad_id'] ?? '';
    }

    public function validar() {
        if (!$this->fecha_cita) {
            self::$errores[] = 'La fecha es obligatoria.';
        }
        if (!$this->hora_cita) {
            self::$errores[] = 'Es obligatorio seleccionar una hora.';
        }
        if (!$this->especialidad_id) {
            self::$errores[] = 'La especialidad es obligatoria.';
        }
        return self::$errores;
    }
}
