<header>
    <div class="container1">
        <nav class="navbar navbar-expand-lg navbar-light text-white">
            <a class="navbar-brand" href="<?php echo URL_PROJECT ?>/">
                <img src="<?php echo URL_PROJECT ?>/img/logo.jpg" width="40px" alt="Logo" class="image-logo">
            </a>

            <input type="checkbox" id="check">


            <button for="check" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
             aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
            </button>



            <div class="collapse navbar-collapse" id="navbarSupportedContent" 
                style = "display: flex;
                        justify-content: space-between ">

                <ul class="navbar-nav navbar-left">
                    
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo URL_PROJECT ?>/home/usuarios"><span class="big"><i class="fas fa-home mr-1"></i></span>Usuarios</a>
                    </li>
                    <li class="nav-item">

                        <form action="<?php echo URL_PROJECT ?>/home/buscar" class="tipe-form form-inline my-2 my-lg-0" method="POST">
                            <input type="text" name="buscar" class="form-style" placeholder="Buscar" />
                            <button class="btn-form" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </li>
                </ul>

                <div class="navbar-right">

                    <div class="links">
                        <div class="notificacion-container">
                            <a href="<?php echo URL_PROJECT ?>/mensajes" class="notificacion-container"><span class="big"><i class="far fa-envelope"></i></span></a>
                            <?php if($datos['misMensajes2'] > 0): ?>
                                <div class="bg-notificacion"><?php echo $datos['misMensajes2'] ?></div>
                            <?php endif ?>
                            </a>
                        </div>
                    </div>

                    <div class="links">
                        <div class="notificacion-container">

                            <a href="<?php echo URL_PROJECT ?>/notificaciones" class="notificacion-container"><span class="big"> <i class="fas fa-bell"> </i></span>
                            <?php if($datos['misNotificaciones'] > 0): ?>
                                <div class="bg-notificacion"><?php echo $datos['misNotificaciones'] ?></div>
                                <?php endif ?>
                            </a>
                            
                        </div>
                    </div>

                    <div class="dropdown">
                        <span class="btn-radio dropdown-toggle" id="actionPerfil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          
                        <a href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datos['usuario']->usuario ?>"><img style="width: 40px;
    height: 40px;
    margin-right: 10px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #10D589;"  src="<?php echo URL_PROJECT . '/' . $datos['perfil']->fotoPerfil ?>" alt="perfil" class="image-border" />
                        </a>


                            <?php echo ucwords($_SESSION['usuario']); ?>
                        </span>
                        <div class="dropdown-menu" aria-labelledby="actionPerfil">
                            <a class="dropdown-item text-dark" href="<?php echo URL_PROJECT?>/home/logout">Salir</a>
                        </div>
                        <!-- <script>
                            const span = document.getElementById('actionPerfil');
                            const logout = document.querySelector('dropdown-item');

                            span.style.display = 'none';

                            function logoutBlock()
                        </script> -->
                    </div>
                
                </div>
            </div>
        </nav>
    </div>
</header>




<?php

include_once URL_APP . '/views/custom/footer.php';

?>
