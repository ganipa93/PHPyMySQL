<html>

    <head>
        <title>CRUD</title>
    </head>

    <body>

        <?php
        
            require "include/db.php";
            require "include/clientes.php";
            require "template/menu.php";

            \db\conectar(
                            'mysql:host=localhost;dbname=misitio',
                            'root',
                            ''
            ); 

            $pagina =   isset($_GET['p']) ? $_GET['p'] : '';

            switch(strtolower($pagina)){

                case 'listado':
                    require "paginas/clientes/listado.php";
                break;

                case 'nuevo':

                    $success    =   'Se agrego correctamente el cliente';
                    $error      =   'No pudo agregarse el cliente!';
                    $resultado  =   NULL;

                    if($_SERVER['REQUEST_METHOD'] == 'POST'){

                        $resultado = \clientes\nuevo($_POST);

                    }

                    $titulo  = 'Alta de cliente';
                    $cliente = Array();
                    $submit  = "Agregar cliente";

                    require "paginas/clientes/crud_cliente.php";

                break;

                case 'editar':

                    $success    =   'Se edito correctamente el cliente';
                    $error      =   'No se pudo actualizar el cliente!';
                    $resultado  =   NULL;

                    if(isset($_GET['id'])){
                        
                        if($_SERVER['REQUEST_METHOD'] == 'POST'){

                            $resultado = \clientes\actualizar($_GET['id'],$_POST);

                        }
                        
                        $submit  = "Actualizar cliente";
                        $titulo  = 'Editar cliente';

                        $cliente = \clientes\obtenerPorId($_GET['id']);

                        require "paginas/clientes/crud_cliente.php";

                    }

                break;
                
                case 'borrar':

                    $resultado  =   NULL;
                    $success    =   "Se ha borrado correctamente el cliente";
                    $error      =   "No pudo borrarse el cliente";

                    if(isset($_GET['id'])){
                        
                        if($_SERVER['REQUEST_METHOD'] == 'POST'){

                            $resultado = \clientes\borrar($_GET['id']);

                        }
                        
                        $submit  = "Borrar";
                        $titulo  = 'Esta seguro que desea borrar el cliente?';

                        $cliente = \clientes\obtenerPorId($_GET['id']);

                        require "paginas/clientes/borrar.php";

                    }

                break;

                default:
                    require "paginas/home.php";
                break;

            }

        ?>
    </body>

</html>