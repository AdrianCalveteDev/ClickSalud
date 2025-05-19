<?php

namespace App;

class Especialidad extends ActiveRecord {

    // Sobreescritura de la variable tabla heredada de la clase padre ActiveRecord
    protected static $tabla = 'especialidades';
    // Reescribimos las columnas de la tabla
    protected static $columnasBaseDatos = ['id', 'nombre', 'descripcion', 'descripcion_larga', 'descripcion_larga_2', 'logo', 'imagen', 'creado_en', 'actualizado_en'];

    public $id;
    public $nombre;
    public $descripcion;
    public $descripcion_larga;
    public $descripcion_larga_2;
    public $logo;
    public $imagen;
    public $creado_en;
    public $actualizado_en;

    // Creamos el constructor de la clase
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->descripcion_larga = $args['descripcion_larga'] ?? '';
        $this->descripcion_larga_2 = $args['descripcion_larga_2'] ?? '';
        $this->logo = $args['logo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->creado_en = date('Y-m-d H:i:s');
        $this->actualizado_en = date('Y-m-d H:i:s');
    }

    public function validar(){
         /* VALIDAMOS LOS DATOS DEL FORMULARIO */
        // Si el nombre no se rellena, llenamos el array de errores con el error correspondiente.
        if(!$this->nombre) {
            self::$errores[] = "El nombre de la especialidad es obligatorio";
        }
        // Si no se pone un precio, le indicamos al usuario mediante mensaje de error que es obligatio.
        if(!$this->descripcion){
            self::$errores[] = "La descripción es obligatoria";
        }
        // De la misma manera, indicamos al usuario que debe definir la duración del servicio.
        if(!$this->logo){
            self::$errores[] = "El logo es obligatorio.";
        }
        if(!$this->imagen){
            self::$errores[] = "La imágen es obligatoria";
        }
        return self::$errores;
    }
}