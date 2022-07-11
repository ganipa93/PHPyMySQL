<?php

    $id         =   isset($cliente['id'])               ? $cliente['id']                : '';
    $nombre     =   isset($cliente['nombre'])           ? $cliente['nombre']            : '';
    $apellido   =   isset($cliente['apellido'])         ? $cliente['apellido']          : '';
    $monto      =   isset($cliente['monto_adeudado'])   ? $cliente['monto_adeudado']    : '';

?>

<form method="POST" action="">
    
    <div>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?php echo $nombre;?>"/>
    </div>
    
    <div>
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" value="<?php echo $apellido;?>" />
    </div>

    <div>
        <label for="monto_adeudado">Deuda</label>
        <input type="text" name="monto_adeudado" value="<?php echo $monto;?>" />
    </div>

    <input type="submit" value="<?php echo $submit;?>" />
    
</form>