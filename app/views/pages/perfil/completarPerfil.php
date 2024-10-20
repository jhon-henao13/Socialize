<?php

include_once URL_APP . '/views/custom/header.php';

?>


<div class="completarPerfil">
    <div class="container2">
        <div class="container-perfil shadow-box">
            <h2 class="text-center">Completa tu perfil</h2>
            <h6 class="text-center">Antes de ingresar, debes completar tu perfil</h6>
            <hr>
            <div class="content-completar-perfil center">
                <form style="
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;" action="<?php echo URL_PROJECT ?>/home/insertarRegistrosPerfil" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['logueado'] ?>" required>
                    <div class="form-group">
                        <input type="text" name="nombre" class="form-control" placeholder="Escribe tu nombre" required>
                    </div>
                    
                    <!-- <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="imagen" id="imagen" required>
                            <label class="custom-file-label" for="imagen">Agregar foto</label>
                        </div> -->

                        <div class="image-upload-file-cP">
                            <label for="imagen" class="custom-file-upload-cP">
                                <img src="<?php echo URL_PROJECT ?>/img/user.ico" alt="" class="image-public">
                                <span class="ml-l">Subir foto de perfil</span>
                            </label>
                            <input type="file" name="imagen" id="imagen" class="input-file-hidden" required>


                    </div>
                    <button class="btn-green2 btn-block animate-button">Terminar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php

include_once URL_APP . '/views/custom/footer.php';

?>