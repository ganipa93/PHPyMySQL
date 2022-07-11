<?php $clientes = \clientes\buscar($_GET); ?>

<form method="GET" action="">

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" />
    
    <label for="apellido">Apellido</label>
    <input type="text" name="apellido" />

    <label for="monto_adeudado">Monto adeudado</label>
    <input type="text" name="monto_adeudado" />    

    <input type="hidden" name="p" value="<?= htmlentities($_GET['p'])?>" />
    
    <input type="submit" value="Buscar" />
    
</form>

<table>

    <thead>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Deuda</th>
        <th></th>
    </thead>

    <tbody>
    <?php foreach($clientes as $cliente): ?>
        <tr>
            <td><?php echo $cliente['nombre'];?></td>
            <td><?php echo $cliente['apellido'];?></td>
            <td><?php echo $cliente['monto_adeudado'];?></td>
            <td>
                <a href="index.php?p=editar&id=<?php echo $cliente["id"]?>">Editar</a>
                <a href="index.php?p=borrar&id=<?php echo $cliente["id"]?>">Borrar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
