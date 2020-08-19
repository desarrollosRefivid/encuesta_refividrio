<?php

require 'header.php';

?>

<!-- TABLA INICIO -->
<div class="container" id="crudApp">
   <br />
   <h3 align="center">Empresa</h3>
   <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">
       <h3 class="panel-title">Datos</h3>
      </div>
      <div class="col-md-6" align="right">
       <input type="button" class="btn btn-success btn-xs" @click="openModel" value="Agregar" />
      </div>
     </div>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
        <th>Empresa</th>
        <th>Editar</th>
        <th>Eliminar</th>
       </tr>
       <tr v-for="row in allData">
        <td>{{ row.empresa_nombre }}</td>
        <td><button type="button" name="edit" class="btn btn-primary btn-xs edit" @click="fetchData(row.id_empresa)">Editar</button></td>
        <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteData(row.id_empresa)">Eliminar</button></td>
       </tr>
      </table>
     </div>
    </div>
   </div>

   <div v-if="myModel">
    <transition name="model">
     <div class="modal-mask">

       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">
          <h4 class="modal-title">{{ dynamicTitle }}</h4>
          <button type="button" class="close" @click="myModel=false"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
          <div class="form-group">
           <label>Empresa</label>
           <input type="text" class="form-control" v-model="first_name" />
          </div>
          <div class="form-group">
           <label>R.F.C.</label>
           <input type="text" class="form-control" v-model="last_name" />
          </div>
          <div class="custom-control custom-checkbox">
           <input type="checkbox" class="custom-control-input" id="checked" v-model="checked"  false-value="false" true-value="true" >
           <label class="custom-control-label" for="checked">Activo</label>
          </div>
          
          <br />
          <div align="center">
           <input type="hidden" v-model="hiddenId" />
           <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submitData" />
          </div>
         </div>
        </div>
       </div>
     </div>
    </transition>
   </div>
  </div>

        </div>
        <!-- /.container-fluid -->

<script type="text/javascript" src="../js/admin/company.js"></script>

