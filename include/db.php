<?php

    namespace db{

        /**
         * Se conecta a la base de datos especificada mediante el parametro $dsn
         * 
         * @staticvar \PDO $pdo contiene la conexion (estilo singleton)
         * @param string $dsn
         * @param string $username Nombre de usuario
         * @param string $password Clave
         * @return \db\PDO
         */

        function conectar($dsn=NULL,$username='root',$password=''){

            static $pdo = NULL;

            if($pdo){

                return $pdo;

            }

            $pdo =  new \PDO($dsn,$username,$password);

            return $pdo;

        }

        /**
         * Realiza un query de tipo SELECT 
         * @param string $sql la sentencia SQL a ejecutar
         * @param Array $values valores del query para especificar 
         * en la clausula WHERE u otros parametros.
         * 
         * @return PDOStatement Objeto de tipo PDOStatement
         * @return boolean FALSE en caso de que el query no se haya ejecutado 
         * correctamente.
         */

        function select($sql,$values=Array()){

            $pdo    =   conectar();

            $stmt   =   $pdo->prepare($sql);

            foreach($values as $field=>$value){

                $stmt->bindValue(":$field",$value);

            }

            if(!$stmt->execute()){

                return FALSE;

            }

            return $stmt;

        }
        
        /**
         *
         * Inserta valores en una tabla
         * 
         * @param string $tabla el nombre de la tabla en la cual insertar
         * @param Array $valores Un array con los campos a insertar
         * @return boolean FALSE en caso de que no se haya podido insertar
         * @return int En caso de que se haya podido insertar
         */
        
        function insert($tabla,$valores=Array()){
            
            $sql = "INSERT INTO $tabla SET ";
            $insert = Array();

            foreach($valores as $campo=>$valor){

                $insert[] = "$campo=:$campo";

            }
            
            $sql .= implode(',',$insert);
  
            $pdo  = conectar();
            
            $stmt = $pdo->prepare($sql);

            foreach($valores as $campo=>$valor){

                $stmt->bindValue(":$campo",$valor);

            }

            if(!$stmt->execute()){

                return FALSE;

            }
            
            return $pdo->lastInsertId();

        }
        

        /**
         *
         * Actualiza valores en una tabla
         * 
         * @param string $tabla el nombre de la tabla en la cual actualizar
         * @param Array $where Set de condiciones where
         * @param Array $valores Un array con los campos a actualizar
         * @return boolean FALSE en caso de que no se haya podido insertar
         * @return boolean TRUE en caso de que se haya podido insertar
         */

        function update($tabla,$where=Array(),$valores=Array()){

            $sql    = "UPDATE $tabla SET ";
            $update = Array();

            foreach($valores as $campo=>$valor){

                $update[] = "$campo=:$campo";

            }
            
            $sql .= implode(',',$update);

            if(count($where)){

                $update = Array();

                foreach($where as $campo=>$valor){

                    $update[] = "$campo=:__where_$campo";

                }

                $sql.= " WHERE ".implode(',',$update);

            }

            $pdo  = conectar();
            
            $stmt = $pdo->prepare($sql);

            foreach($valores as $campo=>$valor){

                $stmt->bindValue(":$campo",$valor);

            }
            
            if(count($where)){

                foreach($where as $campo=>$valor){

                    $stmt->bindValue(":__where_$campo",$valor);

                }
                
            }

            if(!$stmt->execute()){

                return FALSE;

            }

            return $stmt->rowCount();

        }
        
        /**
         *
         * Actualiza valores en una tabla
         * 
         * @param string $tabla el nombre de la tabla sobre la cual borrar
         * @param Array $where Set de condiciones where MUY IMPORTANTE
         * @return boolean FALSE en caso de que no se haya podido borrar
         * @return boolean TRUE en caso de que se haya podido borrar
         */

        function delete($tabla,$where=Array()){

            $sql    = "DELETE FROM $tabla";
            $delete = Array();

            foreach($where as $campo=>$valor){

                $delete[] = "$campo=:$campo";

            }
            
            $sql .= " WHERE ".implode(',',$delete);
            $pdo  = conectar();
            
            $stmt = $pdo->prepare($sql);

            foreach($where as $campo=>$valor){

                $stmt->bindValue(":$campo",$valor);

            }

            if(!$stmt->execute()){

                return FALSE;

            }

            return $stmt->rowCount();

        }
                
        

    }