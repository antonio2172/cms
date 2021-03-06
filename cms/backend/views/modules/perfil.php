<?php
    session_start();
    if (!$_SESSION["validar"]) {
        header("location:ingreso");
        exit();
    }
    include "views/modules/botonera.php";
    include "views/modules/cabezote.php";
?>
<!--=====================================
PERFIL       
======================================-->
<div id="editarPerfil" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <h1>Hola <?php echo $_SESSION["usuario"];?>
    <span id="btnEditarPerfil" class="btn btn-info fa fa-pencil pull-left" style="font-size:10px; margin-right:10px"></span></h1>
    <div style="position:relative">
    <img src="<?php echo $_SESSION["photo"];?>" class="img-circle pull-right">
    </div>
    <hr>
    <h4>Perfil: 
      <?php
        if ($_SESSION["email"] == 0) {
          echo "Administrador";
        } else {
          echo "Editor";
        }
      ?>
    </h4>
    <h4>Email: <?php echo $_SESSION["email"];?></h4>
    <h4>Contraseña: *******</h4>
</div>
<!-- editar perfil -->
<div id="formEditarPerfil" style="display: none;" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
  <form method="post" style="padding: 20px;" enctype="multipart/form-data">
    <input type="hidden" name="idPerfil" value="<?php echo $_SESSION["id"];?>">
    <input type="hidden" name="actualizarSesion" value="ok">
    <div class="form-group">
      <input type="text" name="editarUsuario" value="<?php echo $_SESSION["usuario"];?>" maxlength="10" class="form-control" required>
    </div>
    <div class="form-group">
      <input type="password" name="editarPassword" placeholder="Ingrese la contrasena hasta 10 caracteres" maxlength="10" class="form-control" required>
    </div>
    <div class="form-group">
      <input type="email" name="editarEmail" value="<?php echo $_SESSION["email"];?>" class="form-control" required>
    </div>
    <div class="form-group">
      <select name="editarRol" class="form-control" required>
        <option value="">Seleccione el rol</option>
        <option value="0">Administrador</option>
        <option value="1">Editor</option>
      </select>
    </div>
    <div class="form-group text-center">
      <img src="<?php echo $_SESSION["photo"];?>" width="20%" class="img-circle">
      <input type="hidden" value="<?php echo $_SESSION["photo"];?>" name="editarPhoto">
      <input type="file" class="btn btn-default" id="cambiarFotoPerfil" style="display: inline-block; margin: 10px 0">
      <p class="text-center" style="font-size: 12px">Tamano recomendado de la imagen: 100px * 100px, peso maximo 2MB</p>
    </div>
    <input type="submit" id="actualizarPerfil" value="Actualizar perfil" class="btn btn-primary">
  </form>
</div>
<!-- crear perfil -->
<?php
  if ($_SESSION["rol"] == 0) {
    echo '
      <div id="crearPerfil" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <button id="registrarPerfil" class="btn btn-default" style="margin-bottom: 20px">Registrar un nuevo usuario</button>
        <form id="formularioPerfil" method="post" style="display: none;" enctype="multipart/form-data">
          <div class="form-group">
            <input type="text" name="nuevoUsuario" placeholder="Ingrese el nombre de Usuario hasta 10 caracteres" maxlength="10" class="form-control" required>
          </div>
          <div class="form-group">
            <input type="password" name="nuevoPassword" placeholder="Ingrese la contrasena hasta 10 caracteres" maxlength="10" class="form-control" required>
          </div>
          <div class="form-group">
            <input type="email" name="nuevoEmail" placeholder="Ingrese el correo electronico" class="form-control" required>
          </div>
          <div class="form-group">
            <select name="nuevoRol" class="form-control" required>
              <option value="">Seleccione el rol</option>
              <option value="0">Administrador</option>
              <option value="1">Editor</option>
            </select>
          </div>
          <div class="form-group text-center">
            <input type="file" class="btn btn-default" id="subirFotoPerfil" style="display: inline-block; margin: 10px 0">
            <p class="text-center" style="font-size: 12px">Tamano recomendado de la imagen: 100px * 100px, peso maximo 2MB</p>
          </div>
          <input type="submit" id="guardarPerfil" value="Guardar perfil" class="btn btn-primary">
        </form>
    ';
    $crearPerfil = new GestorPerfiles();
    $crearPerfil->guardarPerfilController();
    $crearPerfil->editarPerfilController();
  }
?>
  <hr>
  <div class="table-responsive">
    <table id="tablaSuscriptores" class="table table-striped display">
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Perfil</th>
          <th>Email</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $verPerfiles = new GestorPerfiles();
          $verPerfiles->verPerfilesController();
          $verPerfiles->borrarPerfilController();
        ?>
      </tbody>
    </table>
  </div>
</div>
<!--====  Fin de PERFIL  ====-->