<?php

class Ingreso {

    public function ingresoController() {

        if (isset($_POST["usuarioIngreso"])) {
            if (preg_match('/^[a-zA-Z0-9]*$/', $_POST["usuarioIngreso"]) && preg_match('/^[a-zA-Z0-9]*$/', $_POST["passwordIngreso"])) {

                $encriptar = crypt($_POST["passwordIngreso"], 'llave');

                $datosController = array(
                    "usuario" => $_POST["usuarioIngreso"],
                    // "password" => $_POST["passwordIngreso"]
                    "password" => $encriptar
                );

                $respuesta = IngresoModels::ingresoModel($datosController, "usuarios");

                $intentos = $respuesta["intentos"];
                $usuarioActual = $_POST["usuarioIngreso"];
                $maximoItentos = 2;

                if ($intentos < $maximoItentos) {
                    // if ($respuesta["usuario"] == $_POST["usuarioIngreso"] && $respuesta["password"] == $_POST["passwordIngreso"]) {
                    if ($respuesta["usuario"] == $_POST["usuarioIngreso"] && $respuesta["password"] == $encriptar) {
                        $intentos = 0;
                        $datosController = array("usuarioActual" => $usuarioActual, "actualizarIntentos"=> $intentos);
                        $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

                        session_start();
                        $_SESSION["validar"] = true;
                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["password"] = $respuesta["password"];
                        $_SESSION["email"] = $respuesta["email"];
                        $_SESSION["photo"] = $respuesta["photo"];
                        $_SESSION["rol"] = $respuesta["rol"];

                        header("location:inicio");
                    } else {
                        ++$intentos;
                        $datosController = array("usuarioActual" => $usuarioActual, "actualizarIntentos"=> $intentos);
                        $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

                        echo '<div class="alert alert-danger">Error al ingresar</div>';
                    }
                } else {
                    $intentos = 0;
                    $datosController = array("usuarioActual" => $usuarioActual, "actualizarIntentos"=> $intentos);
                    $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

                    echo '<div class="alert alert-danger">Ha fallado 3 veces!!</div>';
                }
            }
        }
    }
}