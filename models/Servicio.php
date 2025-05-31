<?php

namespace Model;

class Servicio extends ActiveRecord {

    // Sobreescritura de la variable tabla heredada de la clase padre ActiveRecord
    protected static $tabla = 'servicios';
    // Reescribimos las columnas de la tabla
    protected static $columnasBaseDatos = ['id', 'nombre', 'descripcion', 'precio', 'duracion_min', 'especialidad_id','creado_en','actualizado_en', 'imagen'];
 
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $duracion_min;
    public $especialidad_id;
    public $creado_en;
    public $actualizado_en;
    public $imagen;

    // Creamos el constructor de la clase
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->duracion_min = $args['duracion_min'] ?? '';
        $this->especialidad_id = $args['especialidad_id'] ?? '';
        $this->creado_en = date('Y-m-d H:i:s') ?? '';
        $this->actualizado_en = date('Y-m-d H:i:s') ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar(){
         /* VALIDAMOS LOS DATOS DEL FORMULARIO */
        // Si no se selecciona una especialidad, llenamos el array con el error.
        if(!$this->especialidad_id){
            self::$errores[] = "Es necesario seleccionar una especialidad";
        }
        // Si el nombre no se rellena, llenamos el array de errores con el error correspondiente.
        if(!$this->nombre) {
            self::$errores[] = "El nombre es obligatorio";
        }
        // Si no se pone un precio, le indicamos al usuario mediante mensaje de error que es obligatio.
        if(!$this->precio){
            self::$errores[] = "El precio es obligatorio";
        }
        // De la misma manera, indicamos al usuario que debe definir la duración del servicio.
        if(!$this->duracion_min){
            self::$errores[] = "Debes definir la duración del servicio en minutos";
        }
        if(!$this->imagen){
            self::$errores[] = "La imágen es obligatoria";
        }
        return self::$errores;
    }
}