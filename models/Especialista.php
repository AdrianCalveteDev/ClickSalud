<?php

namespace Model;

class Especialista extends ActiveRecord {

    // Sobreescritura de la variable tabla heredada de la clase padre ActiveRecord
    protected static $tabla = 'especialistas';
    // Reescribimos las columnas de la tabla
    protected static $columnasBaseDatos = ['id', 'nombre', 'apellido', 'centro_id', 'especialidad_id', 'creado_en', 'actualizado_en'];

    public $id;
    public $nombre;
    public $apellido;
    public $centro_id;
    public $especialidad_id;
    public $creado_en;
    public $actualizado_en;

    // Creamos el constructor de la clase
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->centro_id = $args['centro_id'] ?? '';
        $this->especialidad_id = $args['especialidad_id'] ?? '';
        $this->creado_en = date('Y-m-d H:i:s');
        $this->actualizado_en = date('Y-m-d H:i:s');
    }

    public function validar(){
         /* VALIDAMOS LOS DATOS DEL FORMULARIO */
        // Si el nombre no se rellena, llenamos el array de errores con el error correspondiente.
        if(!$this->nombre) {
            self::$errores[] = "El nombre de la especialidad es obligatorio.";
        }
        // Si no se pone un precio, le indicamos al usuario mediante mensaje de error que es obligatio.
        if(!$this->apellido){
            self::$errores[] = "El apellido es obligatorio.";
        }
        // De la misma manera, indicamos al usuario que debe definir la duración del servicio.
        if(!$this->centro_id){
            self::$errores[] = "El especialista debe estar asociado a un centro.";
        }
        if(!$this->especialidad_id){
            self::$errores[] = "Hay que asociar una especialidad al especialista.";
        }
        return self::$errores;
    }
}