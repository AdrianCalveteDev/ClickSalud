<?php

namespace App;

class Servicio {

    // Base de datos
    protected static $baseDatos;
    protected static $columnasBaseDatos = ['id', 'nombre', 'descripcion', 'precio', 'duracion_min', 'especialidad_id', 'creado_en', 'actualizado_en', 'imagen'];

    // Validación de datos
    protected static $errores = [];

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $duracion_min;
    public $especialidad_id;
    public $creado_en;
    public $actualizado_en;
    public $imagen;

    // Asignamos la conexión a la base de datos
    public static function setBaseDatos($baseDatos){
        self::$baseDatos = $baseDatos;
    }

    // Creamos el constructor de la clase
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->duracion_min = $args['duracion_min'] ?? '';
        $this->especialidad_id = $args['especialidad_id'] ?? '';
        $this->creado_en = date('Y-m-d H:i:s');
        $this->actualizado_en = date('Y-m-d H:i:s');
        $this->imagen = $args['imagen'] ?? '';
    }

    public function crearRegistro(){
        // Sanitizamos los datos para evitar sql injection y XSS
        $datos = $this->sanitizarDatos();

        // Insertar los datos en la base de datos
        $query = "INSERT INTO servicios ( ";
        $query .= join(', ', array_keys($datos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($datos));
        $query .= " ') ";
        
        $resultado = self::$baseDatos->query($query); 

    }

    // Metodo para IDENTIFICAR y unir los datos de la base de datos
    public function datos(){
        $datos = [];
        foreach(self::$columnasBaseDatos as $columna){
            // Si el nombre de la columna es el id, lo ignoramos ya que es un autoincrement y nosotros no tenemos que incidir sobre el
            if($columna === 'id') continue;
            $datos[$columna] = $this->$columna;
        }
        return $datos;
    }

    // Sanitizamos los datos para evitar sql injection o XSS
    public function sanitizarDatos(){
        $datos = $this->datos();
        $sanitizado = [];

        foreach($datos as $llave => $valor){
            $sanitizado[$llave] = self::$baseDatos->escape_string($valor);
        }

        return $sanitizado;
    }

    /* VALIDACIÓN DE DATOS */
    public static function getErrores(){
        return self::$errores;
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

    public function setImagen($imagen){
        if($imagen){
            $this->imagen =$imagen;
        }
    }

    
}