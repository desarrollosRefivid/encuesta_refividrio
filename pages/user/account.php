<?php require 'headerUser.php';?> 
<div class="container" style="width:90%">  
    <div id="account" style="margin-top:15px;"> 
    <h3>Perfil</h3> 

      <div class="form-group">
        <label>ID: {{account.id_empleado}}</label> 
      
      </div>  

      <div class="form-group">
        <label>Empresa</label>
        <input type="text" class="form-control" v-model="account.empresa_nombre"    :disabled="true" />
      </div>

      <div class="form-group">
        <label>Sucursal</label>
        <input type="text" class="form-control" v-model="account.segmento"    :disabled="true" />
      </div>

      <div class="form-group">
        <label>Nombre</label>
        <input type="text" class="form-control" v-model="account.nombre"    :disabled="true" />
      </div>

      <div class="form-group">
        <label>Apellido Paterno</label>
        <input type="text" class="form-control" v-model="account.paterno"    :disabled="true" />
      </div>

      <div class="form-group">
        <label>Apellido Materno</label>
        <input type="text" class="form-control" v-model="account.materno"    :disabled="true" />
      </div>
 
      <div class="form-group">
        <label>Fecha de Nacimiento</label>
        <input type="date" class="form-control" v-model="account.fecha_nacimiento" />
        <div style="color:red;" id="error_fecha_naci" ></div>
      </div>  

      <div class="form-group">
        <label>*celular</label>
        <input type="text" class="form-control" v-model="account.celular"   />
        <div style="color:red;" id="error_celular" ></div>
      </div> 

      <div class="form-group">
        <label>*Correo</label>
        <input type="mail" class="form-control" v-model="account.correo" />
        <div style="color:red;" id="error_correo" ></div> 
      </div> 
         
      <div class="form-group">
        <label>*Usuario</label>
        <input type="text" class="form-control" v-model="account.usuario" :disabled="true"  />
        <div style="color:red;" id="error_usuario" ></div> 
      </div> 

      <div class="form-group">
        <label>*Genero</label>
        <input type="radio" id="H" value="H" v-model="account.genero"  >
        <label for="H">Hombre</label> 
        <input type="radio" id="M" value="M" v-model="account.genero"  >
        <label for="M">Mujer</label>
        <div style="color:red;" id="error_genero" ></div> 
      </div>  
 
      <div class="form-group">
         <button @click="save()" class="btn btn-info btn-xs" ><img src="../../img/send.png" width="15%" />Guardar</button>
      </div> 
    
    </div> 
</div>
<script type="text/javascript" src="../../js/user/account.js"></script>
