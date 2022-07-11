<?php

    namespace clientes{

        /**
         * Busca un usuario en la tabla de clientes
         * @param array $buscar campos por los cuales buscar
         * @return Array
         */
        
        function buscar(Array $buscar){
            
            //Definimos cuales son los campos validos por los cuales podemos
            //Realizar una busqueda

            $campos =   Array("id","nombre","apellido","monto_adeudado");

            
            //Quitamos las claves malas (extras) de los valores 
            //enviados para buscar
            foreach($buscar as $clave=>$valor){
                
                if(!in_array($clave,$campos)){

                    unset($buscar[$clave]);

                }
                
            }

            //Si no hay nada para buscar, devolvemos simplemente todo el listado
            if(empty($buscar)){

                return listar();

            }

            //Si tenemos datos a buscar, entonces conformamos el query 
            
            $sql = sprintf("SELECT %s FROM clientes",implode(',',$campos));

            
            //Creamos un array el cual contenga nuestras clausulas con like
            $where = Array();
            
            //La variable bind sirve para pasarla en el momento que hacemos 
            //ejecucion del query, en vez de utilizar bindParam o bindValue

            $bind = Array();

            foreach($buscar as $campo=>$valor){
                
                $where[] = "$campo LIKE ? ";
                $bind[]  =   "%$valor%";

            }

            //Agregamos los LIKE a nuestra consulta SQL principal
            $sql = sprintf('%s WHERE %s',$sql,implode(' AND ',$where));

            //Preparamos la consulta para su ejecucion

            $conexion = \db\conectar();
            
            $stmt = $conexion->prepare($sql);

            $stmt->execute($bind);

            //Devolvemos los resultados

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
        }
        
        function listar(){
            
            $campos =   "id,nombre,apellido,monto_adeudado";
            $sql    =   "SELECT $campos FROM clientes";
            
            return \db\select($sql);

        } 
        
        /**
         * Agrega un nuevo cliente a la tabla de clientes
         * 
         * @param Array $datos un array que contiene las columnas
         * de una fila de la tabla clientes (menos el id)
         * 
         * @return int El id del nuevo registro insertado (si se pudo insertar)
         * @return NULL en caso de que falte algun valor requerido en $datos
         * @return boolean FALSE (en caso de que no se haya podido insertar)
         */
        
        function nuevo($datos=Array()){

            $clavesRequeridas = Array(
                                        'nombre',
                                        'apellido',
                                        'monto_adeudado'
            );
            
            if(array_diff($clavesRequeridas,array_keys($datos))){

                return NULL;

            }
            
            return \db\insert('clientes',$datos);            

        }

        function obtenerPorId($id){
            
            $campos =   "id,nombre,apellido,monto_adeudado";
            $query  =   "SELECT $campos FROM clientes WHERE id=:id";

            $resultado = \db\select($query, Array('id'=>$id));
            
            if($resultado){

                return $resultado->fetch(\PDO::FETCH_ASSOC);

            }
            
            return FALSE;
            
        }

        /**
         * Borra un cliente de la tabla de clientes mediante su id
         * @param int $id
         * @return type
         */
        
        function borrar($id){

            return \db\delete('clientes',Array('id'=>$id));

        }
        

        /**
         * Actualiza un cliente mediante su id (identificador unico)
         * @param int El id del cliente a actualizar
         * @param Array Los nuevos datos a actualizar en el registro
         * donde el id sea igual a $id
         */
        
        function actualizar($id,$datos=Array()){

            $resultado = \db\update('clientes',Array('id'=>$id),$datos);

            if($resultado === FALSE){
                return FALSE;
            }

            return $resultado>=0;
            
        }        

    }