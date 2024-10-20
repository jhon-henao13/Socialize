<?php

include_once URL_APP . '/views/custom/header.php';

?>


<style>
    body {
        background-color: #001E1A;
    }
</style>


<div class="container-center center">
    <div class="container-content center">
        <div class="content-action center">
            <h4>Registrate</h4>
            <form action="<?php echo URL_PROJECT?>/home/register" method="post">
                <input type="email" name="email" placeholder="Correo electronico" required>
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button class="btn-green btn-block">Crear</button>
            </form>
            <?php if(isset($_SESSION['usuarioError'])) : ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2 mb-2" role="alert">
                <?php echo $_SESSION['usuarioError']?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['usuarioError']);
            endif ?>
            <div class="contenido-link mt-2">
                <span class="mr-2">¿Ya tienes cuenta?</span><a href="<?php echo URL_PROJECT?>/home/login">Ingresar</a>
            </div>
        </div>
        <div class="content-image center">
            <img src="<?php echo URL_PROJECT ?>/img/vector.png" alt="Imagen de login">
        </div>
    </div>
</div>

<?php

include_once URL_APP . '/views/custom/footer.php';

?>