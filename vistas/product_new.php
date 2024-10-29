<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Nuevo producto</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		require_once "./php/main.php";
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/producto_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label><strong>No. Recibo</strong></label>
				  	<input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label><strong>Productor</strong></label>
				  	<input class="input" type="text" name="producto_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		</div>
		<label><strong>Catación</strong></label>
		<div class="columns">
		  	<div class="column">
				<div class="control">
					<label>Clase</label>
                    <input class="input" type="text" value="PER" readonly>
                </div>
		  	</div>
			  <div class="column">
			  <div class="control">
                    <label>Tipo</label>
                    <div class="select is-rounded">
                        <select name="tipo" required>
                            <option value="">Seleccione una opción</option>
                            <option value="XP">Extra Prime</option>
                            <option value="PR">Prime</option>
                            <option value="SH">Semi Duro</option>
                            <option value="HB">Duro</option>
                            <option value="SHB">Estrictamente Duro</option>
                        </select>
                    </div>
                </div>
		  	</div>
			  <div class="column">
			  <div class="control">
                    <label>Tueste</label>
                    <div class="select is-rounded">
                        <select name="tueste" required>
                            <option value="">Seleccione una opción</option>
                            <option value="BUE">Bueno</option>
                            <option value="SAN">Sana</option>
                            <option value="NOR">Normal</option>
                            <option value="DEF">Defectuosa</option>
                            <option value="VIN">Vinosa</option>
                            <option value="FRU">Frutosa</option>
                            <option value="DIS">Dispareja</option>
                            <option value="MBU">Muy Buena</option>
                            <option value="AS">Aspera</option>
                        </select>
                    </div>
                </div>
		  	</div>
			  <div class="column">
			  <div class="control">
                    <label>Taza</label>
                    <div class="select is-rounded">
                        <select name="taza" required>
                            <option value="">Seleccione una opción</option>
                            <option value="BUE">Bueno</option>
                            <option value="SAN">Sana</option>
                            <option value="NOR">Normal</option>
                            <option value="DEF">Defectuosa</option>
                            <option value="VIN">Vinosa</option>
                            <option value="FRU">Frutosa</option>
                            <option value="DIS">Dispareja</option>
                            <option value="MBU">Muy Buena</option>
                            <option value="AS">Aspera</option>
                        </select>
                    </div>
                </div>
		  	</div>
			  <div class="column">
			  <div class="control">
                    <label>Secamiento</label>
                    <div class="select is-rounded">
                        <select name="secamiento" required>
                            <option value="">Seleccione una opción</option>
                            <option value="BUE">Bueno</option>
                            <option value="SAN">Sana</option>
                            <option value="NOR">Normal</option>
                            <option value="DEF">Defectuosa</option>
                            <option value="VIN">Vinosa</option>
                            <option value="FRU">Frutosa</option>
                            <option value="DIS">Dispareja</option>
                            <option value="MBU">Muy Buena</option>
                            <option value="AS">Aspera</option>
                        </select>
                    </div>
                </div>
		  	</div>
			  <div class="column">
			  <div class="control">
                    <label>Catación General</label>
                    <div class="select is-rounded">
                        <select name="catacion_general" required>
                            <option value="">Seleccione una opción</option>
                            <option value="BUE">Bueno</option>
                            <option value="SAN">Sana</option>
                            <option value="NOR">Normal</option>
                            <option value="DEF">Defectuosa</option>
                            <option value="VIN">Vinosa</option>
                            <option value="FRU">Frutosa</option>
                            <option value="DIS">Dispareja</option>
                            <option value="MBU">Muy Buena</option>
                            <option value="AS">Aspera</option>
                        </select>
                    </div>
                </div>
		  	</div>
		</div>
		<label><strong>Ubicación</strong></label>

		<div class="columns">
			  <div class="column">
			  <div class="control">
                    <label>Bodega</label>
                    <div class="select is-rounded">
                        <select name="bodega" required>
                            <option value="">Seleccione una opción</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                        </select>
                    </div>
                </div>
		  	</div>
			  <div class="column">
			  <div class="control">
                    <label>Tarima</label>
                    <input class="input" type="text" name="tarima" pattern="^[0-9]+$" oninput="this.value = this.value.replace(/[^0-9]/g, '');"required>
                </div>
		  	</div>
			  <div class="column">
			  <div class="control">
                    <label>Cama Inicial</label>
                    <input class="input" type="text" name="cama_inicial" pattern="^[0-9]+$" oninput="this.value = this.value.replace(/[^0-9]/g, '');"required>
                </div>
			  </div>
			  <div class="column">
			  <div class="control">
                    <label>Cama Final</label>
                    <input class="input" type="text" name="cama_final" pattern="^[0-9]+$" oninput="this.value = this.value.replace(/[^0-9]/g, '');"required>
                </div>
		  	</div>
			  <div class="column">
			  <div class="control">
                    <label>Volando</label>
                    <input class="input" type="text" name="volando" pattern="^[0-9]+$" oninput="this.value = this.value.replace(/[^0-9]/g, '');"required>
                </div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label><strong>Quintalaje</strong></label>
				  	<input class="input" type="text" name="producto_quintalaje" pattern="[0-9]{1,25}" maxlength="25" required >
				</div>
		  	</div>
		  	<div class="column">
				<label><strong>Preparación</strong></label><br>
		    	<div class="select is-rounded">
				  	<select name="producto_categoria" >
				    	<option value="" selected="" >Seleccione una opción</option>
				    	<?php
    						$categorias=conexion();
    						$categorias=$categorias->query("SELECT * FROM categoria");
    						if($categorias->rowCount()>0){
    							$categorias=$categorias->fetchAll();
    							foreach($categorias as $row){
    								echo '<option value="'.$row['categoria_id'].'" >'.$row['categoria_nombre'].'</option>';
				    			}
				   			}
				   			$categorias=null;
				    	?>
				  	</select>
				</div>
		  	</div>
		</div>
		<div class="columns">
			<div class="column">
				<label><strong>Foto o imagen del producto</strong></label><br>
				<div class="file is-small has-name">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
			</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>