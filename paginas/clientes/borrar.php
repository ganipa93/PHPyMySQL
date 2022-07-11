<h2>
<?php
    if($resultado !== NULL){
        echo $resultado ? $success : $error;
    }
?>
</h2>

<a href="/crud/index.php?p=listado">Volver al listado!</a>

<?php if($resultado  === NULL): ?>

<h1><?php echo $titulo;?></h1>

<div>

    <div>ID: <?php echo $cliente["id"];?></div>
    <div>Nombre: <?php echo $cliente["nombre"];?></div>
    <div>Apellido: <?php echo $cliente["apellido"];?></div>
    <div>Deuda: <?php echo $cliente["monto_adeudado"];?></div>

</div>


<form method="POST">
    <input type="submit" value="<?php echo $submit;?>" />
</form>

<?php endif;?>