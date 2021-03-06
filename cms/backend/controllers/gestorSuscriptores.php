<?php

class SuscriptoresController {
    // mostrar suscriptores en la vista
    public function mostrarSuscriptoresController() {
        $respuesta = SuscriptoresModel::mostrarSuscriptoresModel("suscriptores");
        foreach ($respuesta as $row => $item) {
            echo '
                <tr>
                    <td>' . $item["nombre"] . '</td>
                    <td>' . $item["email"] . '</td>
                    <td>
                        <a href="index.php?action=suscriptores&idBorrar=' . $item["id"] . '">
                            <span class="btn btn-danger fa fa-times quitarSuscriptor"></span>
                        </a>
                    </td>
                    <td></td>
                </tr>
            ';
        }
    }

    // borrar suscriptores
    public function borrarSuscriptoresController() {
        if (isset($_GET["idBorrar"])) {
            $datosController = $_GET["idBorrar"];
            $respuesta = SuscriptoresModel::borrarSuscriptoresModel($datosController, "suscriptores");
            if ($respuesta == "ok") {
                echo '
                    <script>
                        swal({
                            title: "¡OK!",
                            text: "¡El suscrito se ha borrado correctamente!",
                            type: "success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                window.location = "suscriptores";
                            }
                        });
                    </script>
                ';
            }
        }
    }

    // imprimir suscriptores
    public function impresionSuscriptoresController($datos) {
        $datosController = $datos;
        $respuesta = SuscriptoresModel::mostrarSuscriptoresModel($datosController);
        return $respuesta;
    }

    // sucriptores sin revisar
    public function suscriptoresSinRevisarController() {
        $respuesta = suscriptoresModel::suscriptoresSinRevisarModel("suscriptores");
        $sumaRevision = 0;
        foreach ($respuesta as $key => $value) {
            if ($value["revision"] == 0) {
                $sumaRevision++;
                echo '<span>' . $sumaRevision . '</.span>';
            }
        }
    }

    // suscriptores revisados
    public function suscriptoresRevisadosController($datos) {
        $datosController = $datos;
        $respuesta = suscriptoresModel::suscriptoresRevisadosModel($datosController, "suscriptores");
        echo $respuesta;
    }
}