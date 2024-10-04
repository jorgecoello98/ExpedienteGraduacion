<?php

    include("../../Resources/lib/connection.php");
    include("../../Resources/config.php");

    if(!empty($_POST["id"]) && !empty($_POST["cuenta"]) && !empty($_FILES["file"]) && !empty($_POST["ruta"]) && !empty($_POST["codigo"]) && !empty($_POST["extension"]) && !empty($_POST["id_solicitud"])){

        $id = $_POST["id"];
        $id_solicitud = $_POST["id_solicitud"];
        $cuenta = $_POST["cuenta"];
        $documento = $_FILES["file"];
        $ruta = $_POST["ruta"];
        $codigo = $_POST["codigo"];
        $extension = $_POST["extension"];

        $nombre_archivo = '/'.$cuenta;   

        //ASIGANMOS EL NOMBRE AL DOCUMENTO SEGUN SEA SU CODIGO

        if($codigo == "1"){
            $nombre_archivo.="_Constancia_verificacion_nombre";
        }

        if($codigo == "2"){
            $nombre_archivo.="_Copia_identidad";
        }

        if($codigo == "3"){
            $nombre_archivo.="_Certificacion_notas";
        }

        if($codigo == "4"){
            $nombre_archivo.="_Constancia_horas_VOAE";
        }

        if($codigo == "5"){
            $nombre_archivo.="_Constancia_solvencia_biblioteca";
        }

        if($codigo == "6"){
            $nombre_archivo.="_Constancia_finalizacion_practica";
        }

        if($codigo == "7"){
            $nombre_archivo.="_Constancia_aprobacion_examen_himno";
        }

        if($codigo == "8"){
            $nombre_archivo.="_Extension_titulos_secretaria";
        }

        if($codigo == "9"){
            $nombre_archivo.="_Constancia_UV";
        }

        if($codigo == "10"){
            $nombre_archivo.="_Titulo_secundaria";
        }

        if($codigo == "11"){
            $nombre_archivo.="_Pago_derecho_graduacion";
        }

        if($codigo == "12"){
            $nombre_archivo.="_Pago_carnet";
        }

        if($codigo == "13"){
            $nombre_archivo.="_Pago_timbre";
        }

        if($codigo == "14"){
            $nombre_archivo.="_Fotos";
        }

        if($codigo == "15"){
            $nombre_archivo.="_Solvencia_registro";
        }

        if($codigo == "16"){
            $nombre_archivo.="_Otros";
        }

        if($codigo == "17"){
            $nombre_archivo.="_Constancia_conducta";
        }

        if($codigo == "18"){
            $nombre_archivo.="_Formulario_honores_academicos";
        }

        $nombre_archivo.= '.'.$extension;                   //AGREGAMOS LA EXTENSION AL ARCHIVO


        $ruta_final = $BASEPATHEXPEDIENTES.''.$ruta .''. $nombre_archivo;           //OBTENEMOS LA RUTA FINAL CON EL DIRECTORIO Y DOCUMENTO

        /**VALIDAMOS QUE EL DOCUMENTO NO TENGA NINGUN ERROR */
        if ( 0 < $_FILES['file']['error'] ) {
            echo 'Error';
            die;
        }

        /**EN CASO DE QUE SE QUIERE CAMBIAR EL DOCUMENTO, ELIMINAMOS EL ACTUAL */
        if(file_exists($ruta_final)){

            unlink($ruta_final);

        }
            
        //SE ALMACENARA EN LA BASE DE DATOS SOLO CUANDO SEA LA PRIMERA VEZ QUE SE CREA EL FICHERO

        $sp = "call SP_CAMBAIRESTADODOCINVALIDO('$id_solicitud', '$codigo');";
        $query = mysqli_query($connection, $sp);

        if (!$query) {   
            echo 'Error';
            die;
        }

        

        //SUBIMOS EL DOCUMENTO A NUESTRO SERVER 
        $resultado = move_uploaded_file($documento["tmp_name"], $ruta_final);
        @chmod($ruta_final, 0777);
        
        if ($resultado){
            echo 'Exito';
        } else {
            echo 'Error';
        }

        cerrarConexion($connection);

    }else{
        echo 'Error';
    }


    
?>