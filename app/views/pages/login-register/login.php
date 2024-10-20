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
            <h4>Ingrese a su cuenta</h4>
            <form action="<?php echo URL_PROJECT?>/home/login" method="post">
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button class="btn-green btn-block">Ingresar</button>
            </form>
            <!-- Esta es la alerta cuando el usuario o la contraseña son incorrectas -->
            <?php if(isset($_SESSION['errorLogin'])) : ?>
                <div class="alert alert-success alert-dismissible fade show mt-2 mb-2" role="alert">
                    <?php echo $_SESSION['errorLogin']?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['errorLogin']);
            endif ?>

            <!-- Esta es la alerta cuando el registro se completo -->    
            <?php if(isset($_SESSION['loginComplete'])) : ?>
                <div class="alert alert-success alert-dismissible fade show mt-2 mb-2" role="alert">
                <?php echo $_SESSION['loginComplete']?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['loginComplete']);
            endif ?>

            <div class="contenido-link mt-2">
                <span class="mr-2">¿No tienes cuenta?</span><a href="<?php echo URL_PROJECT?>/home/register">Crear cuenta</a>
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