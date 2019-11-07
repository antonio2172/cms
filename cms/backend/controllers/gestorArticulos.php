<?php

class GestorArticulos {

    // mostrar imagen slide
    public function mostrarImagenController($datos) {
        list($ancho, $alto) = getimagesize($datos);
        if ($ancho < 800 || $alto < 400) {
            echo 0;
        } else {
            $aleatorio = mt_rand(100, 999);
            $ruta = "../../views/images/articulos/temp/articulo".$aleatorio.".jpg";
            $origen = imagecreatefromjpeg($datos);
            $destino = imagecrop($origen, ["x" => 0, "y" => 0, "width" => 800, "height" => 400]);
            imagejpeg($destino, $ruta);

            echo $ruta;
        }
    }

    // Guardar articulo
    public function guardarArticuloController() {

        if (isset($_POST["tituloArticulo"])) {
            $imagen = $_FILES["imagen"]["tmp_name"];
            // echo $imagen;

            $borrar = glob("views/images/articulos/temp/*");

            foreach ($borrar as $file) {
                unlink($file);
            }
            $aleatorio = mt_rand(100, 999);
            $ruta = "views/images/articulos/articulo".$aleatorio.".jpg";
            $origen = imagecreatefromjpeg($imagen);
            $destino = imagecrop($origen, ["x" => 0, "y" => 0, "width" => 800, "height" => 400]);
            imagejpeg($destino, $ruta);

            $datosController = array(
                "titulo" => $_POST["tituloArticulo"],
                "introduccion" => $_POST["introArticulo"]."...",
                "ruta" => $ruta,
                "contenido" => $_POST["contenidoArticulo"]
            );
            
            $respuesta = GestorArticulosModel::guardarArticuloModel($datosController, "articulos");

            if ($respuesta == "ok") {
                echo '
                    <script>
                        swal({
                            title: "¡OK!",
                            text: "¡El articulo se subió correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                window.location = "articulos";
                            }
                        });
                    </script>
                ';
            } else {
                // fuck 🙃
                echo $respuesta;
            }
        }
    }

    // Mostrar articulos
    public function mostrarArticulosController() {
        $respuesta = GestorArticulosModel::mostrarArticulosModel("articulos");
        foreach ($respuesta as $row => $item) {
            echo '
                <li>
                    <span>
                        <a href="index.php?action=articulos&idBorrar='.$item["id"].'&rutaImagen='.$item["ruta"].'">
                            <i class="fa fa-times btn btn-danger"></i>
                        </a>
                        <i class="fa fa-pencil btn btn-primary"></i>
                    </span>
                    <img src="'.$item["ruta"].'" class="img-thumbnail">
                    <h1>'.$item["titulo"].'</h1>
                    <p>'.$item["introduccion"].'</p>
                    <a href="#articulo'.$item["id"].'" data-toggle="modal">
                        <button class="btn btn-default">Leer Más</button>
                    </a>
                    <hr>
                </li>
                <div id="articulo'.$item["id"].'" class="modal fade">
                    <div class="modal-dialog modal-content">
                        <div class="modal-header" style="border:1px solid #eee">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">'.$item["titulo"].'</h3>
                        </div>
                        <div class="modal-body" style="border:1px solid #eee">
                            <img src="'.$item["ruta"].'" width="100%" style="margin-bottom:20px">
                            <p class="parrafoContenido">'.$item["contenido"].'</p>
                        </div>
                        <div class="modal-footer" style="border:1px solid #eee">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            ';
        }
    }

    // Borrar articulos
    public function borrarArticuloController() {
        if (isset($_GET["idBorrar"])) {
            unlink($_GET["rutaImagen"]);
            $datosController = $_GET["idBorrar"];

            $respuesta = GestorArticulosModel::borrarArticuloModel($datosController, "articulos");

            if ($respuesta = "ok") {
                echo '
                    <script>
                        swal({
                            title: "¡OK!",
                            text: "¡El articulo se borro correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                window.location = "articulos";
                            }
                        });
                    </script>
                ';
            } else {
                // fuck 🙃
                echo respuesta;
            }
        }
    }
}
