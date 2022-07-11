<h1><?php $titulo;?></h1>

<div class="resultado">
    <h1>
        <?php
            if($resultado !== NULL){

                echo $resultado ? $success : $error;

            }
        ?>
    </h1>
</div>

<?php require "template/form_cliente.php";?>