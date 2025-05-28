<?php

namespace Model;

class ActiveRecord{
     // Base de datos
    protected static $baseDatos;
    protected static $columnasBaseDatos = [];
    protected static $tabla = '';

    // Validación de datos
    protected static $errores = [];

    // Asignamos la conexión a la base de datos
    public static function setBaseDatos($baseDatos){
        self::$baseDatos = $baseDatos;
    }

    public function guardar($ruta){
        if(!is_null($this->id)){
            // actualizamos el registro
            $this->actualizarRegistro($ruta);
        } else {
            // creamos un nuevo registro
            $this->crearRegistro($ruta);
        }
    }

    public function crearRegistro($ruta){
        // Sanitizamos los datos para evitar sql injection y XSS
        $datos = $this->sanitizarDatos();

        // Insertar los datos en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($datos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($datos));
        $query .= " ') ";
        
        $resultado = self::$baseDatos->query($query);

        if($resultado){
            //Si el formulario funciona correctamente, redirigimos al usuario a la página del administrador
            header('Location: ' . $ruta . '?resultado=1');
        }
    }

    public function actualizarRegistro($ruta){
        // Sanitizamos los datos para evitar sql injection y XSS
        $datos = $this->sanitizarDatos();

        $valores = [];
        foreach($datos as $llave => $valor){
            $valores[] = "$llave='$valor'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$baseDatos->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$baseDatos->query($query);

        if($resultado){
            //Si el formulario funciona correctamente, redirigimos al usuario a la página del administrador
            // pasandole la variable resultado=2 para mostrar mensaje de actualización al usuario
             header('Location: ' . $ruta . '?resultado=2');
        } else {
            // Mostrar el error (para debuguear)
            // echo "Error en la consulta: " . mysqli_error($baseDatos);
        }
    }

    // Eliminar un registro
    public function eliminar($ruta){

        // Query para eliminar el registro por su ID
        $queryEliminar = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$baseDatos->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$baseDatos->query($queryEliminar);

        // Si hay un registro eliminado redirigimos al usuario al index de administrador con el id para resultado de 3
        if ($resultado){
            $this->borrarImagen();
            header('Location: ' . $ruta . '?resultado=3');
        }
    }

    // Metodo para IDENTIFICAR y unir los datos de la base de datos
    public function datos(){
        $datos = [];
        foreach(static::$columnasBaseDatos as $columna){
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
        return static::$errores;
    }
    public function validar(){
        static::$errores = []; 
        return static::$errores;
    }

    public function setImagen($imagen){
        // Eliminar la imagen previa (si existe)
        if(!is_null($this->id)){
            // Comprobamos si existe el archivo para no generar errores
            $this->borrarImagen();
        }

        // Asignamos al atributo imagen el nombre de la imagen y lo guardamos en memoria
        if($imagen){
            $this->imagen =$imagen;
        }
    }

    // Setear el logo
    public function setLogo($logo){
        // Eliminar la imagen previa (si existe)
        if(!is_null($this->id)){
            // Comprobamos si existe el archivo para no generar errores
            $this->borrarImagen();
        }

        // Asignamos al atributo imagen el nombre de la imagen y lo guardamos en memoria
        if($logo){
            $this->logo = $logo;
        }
    }

    // Eliminar archivo
    public function borrarImagen(){
        // Comprobamos si existe el archivo para no generar errores
        $archivoServicioExiste = file_exists(CARPETA_IMAGENES_SERVICIOS . $this->imagen);
        $archivoEspecialidadExiste = file_exists(CARPETA_IMAGENES_ESPECIALIDADES . $this->imagen);
        if($archivoServicioExiste){
            unlink(CARPETA_IMAGENES_SERVICIOS  . $this->imagen);
        } elseif ($archivoEspecialidadExiste) {
            unlink(CARPETA_IMAGENES_ESPECIALIDADES . $this->imagen);
        } else {
            // echo "El archivo no existe";
            // echo "/../../../imagenes/servicios/".$this->imagen;
            // exit;
        }
    }

    // READ
    // Listar todos los servicios
    public static function all($limite = null){

        if ($limite === null) {
            $query = "SELECT * FROM " . static::$tabla;
        } else {
            $query = "SELECT * FROM " . static::$tabla . " LIMIT ". $limite;
        }
        
        $resultado = self::consultaSQL($query);

        return $resultado;
    }
    // Buscar por su id
    public static function buscar($id) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
            $resultado = self::consultaSQL($query);

            // Devolvemos el primer elemento del array
            return array_shift($resultado); // array_shift, devuelve el primer elemento de un array
    }
    public static function consultaSQL($query){
        // Consultar la base de datos
        $resultado = self::$baseDatos->query($query);

        // Iterar los resultados y añadirlos a un array
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Recuperar los resultados
        return $array;
    }
    protected static function crearObjeto($registro){
        $objeto = new static;

        foreach($registro as $llave => $valor) {
            if(property_exists($objeto, $llave)){
                $objeto->$llave = $valor;
            }
        }

        return $objeto;
    }

    // Sincroniza el objeto de active record con los cambios realizado por el usuario en el UPDATE
    public function sincronizar( $args = [] ){
        foreach($args as $llave => $valor){
            if(property_exists($this, $llave) && !is_null($valor)){
                $this->$llave = $valor;
            }
        }
    }
}