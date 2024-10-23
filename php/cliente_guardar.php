<?php
    
    require_once "main.php";

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['cliente_nombre']);

    $telefono=limpiar_cadena($_POST['cliente_telefono']);
    $email=limpiar_cadena($_POST['cliente_email']);

    /*== Verificando campos obligatorios ==*/
    if($nombre=="" || $telefono==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("^[0-9]+$",$telefono)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El TELÉFONO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando email ==*/
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email=$check_email->query("SELECT cliente_email FROM CLIENTE WHERE cliente_email='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_email=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no valido
                </div>
            ';
            exit();
        } 
    }


    /*== Verificando usuario ==*/
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT cliente_nombre FROM cliente WHERE cliente_nombre='$nombre'");
    if($check_usuario->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CLIENTE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_usuario=null;

    /*== Guardando datos ==*/
    $guardar_usuario=conexion();
    $guardar_usuario=$guardar_usuario->prepare("INSERT INTO cliente(cliente_nombre,cliente_telefono,cliente_email) VALUES(:nombre,:telefono,:email)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":telefono"=>$telefono,
        ":email"=>$email
    ];

    $guardar_usuario->execute($marcadores);

    if($guardar_usuario->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>CLIENTE REGISTRADO!</strong><br>
                El usuario se registro con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el cliente, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_usuario=null;