<?php

	/*== Almacenando datos ==*/
    $client_id_del=limpiar_cadena($_GET['client_id_del']);

    /*== Verificando usuario ==*/
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT cliente_id FROM cliente WHERE cliente_id='$client_id_del'");
    
    if($check_usuario->rowCount()==1){

    	$check_productos=conexion();
    	$check_productos=$check_productos->query("SELECT cliente_id FROM ordenes WHERE cliente_id='$client_id_del' LIMIT 1");

    	if($check_productos->rowCount()<=0){
    		
	    	$eliminar_usuario=conexion();
	    	$eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM cliente WHERE cliente_id=:id");

	    	$eliminar_usuario->execute([":id"=>$client_id_del]);

	    	if($eliminar_usuario->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡CLIENTE ELIMINADO!</strong><br>
		                Los datos del cliente se eliminaron con exito
		            </div>
		        ';
		    }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar el cliente, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_usuario=null;
    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar el cliente ya que tiene órdenes registrados por el
	            </div>
	        ';
    	}
    	$check_productos=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CLIENTE que intenta eliminar no existe
            </div>
        ';
    }
    $check_usuario=null;