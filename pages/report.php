<?php require 'header.php'; ?> 
 
<div  class="container" id="reports"> 
  <h2>Reportes</h2>
  <p>Encuestas Refividrio.</p> 
  <p>

 
    <button   data-toggle="collapse" class="btn btn-link" href="#encuestaAcord"    aria-expanded="false"   >
      <div align="left" > 
        <img src="../img/encuesta.svg" width="10%"   />Encuestas
      </div> 
    </button> 
    </br> 
  </p>
  <div class="collapse" id="encuestaAcord">
    <div class="card card-body">
      <!--  --> 
      <p>
      <button  data-toggle="collapse" href="#encuestaCompletAcord" class="btn btn-link" id="bteConsRes" aria-expanded="false"  >
        Consultar Resultados 
      </button> 
      </br> 
      </p>
      <div class="collapse" id="encuestaCompletAcord">
      <div class="card card-body">
      <!-- content -->

      <div class="container" id="contentForm">  
        <div class="row">
            <div class="col-sm-8">

            <div class="modal-body"> 
              <div class="card-body">  
            <!-- @change='getCountryStates()' --> 
                <label>Empresa:</label>
                  <select class='form-control'  v-model="empresaSelected" @change='getSegments()'>
                    <option value='0' >Selecciona Empresa</option>
                    <option v-for="rows in companys" v-bind:value='rows.id_empresa'>{{ rows.empresa_nombre }}</option>
                  </select> 

                  <label>Segmento:</label>
                  <select class='form-control'  v-model="segmentSelected" @change='getEmployeesBySegment()' >
                    <option value='0' >Todos los Segmentos</option>
                    <option v-for="rows in segments" v-bind:value='rows.id_segmento'>{{ rows.nombre }}</option>
                  </select>

                  <label>Tipo encuestas:</label>
                  <select class='form-control'  v-model="typePoolSelected" @change='getPools()'  >
                    <option value='0' >Todos los tipos de encuestas</option>
                    <option value='1' >Concluidas</option>
                    <option value='2' >En captura</option> 
                  </select> 

                  <label>Encuesta:</label>
                  <select class='form-control'  v-model="pollSelected">
                    <option value='0' >Todas las Encuesta</option>
                    <option v-for="rows in pools" v-bind:value='rows.id_encuesta'>{{ rows.nombre }}</option>
                  </select>

                  <label>empleado:</label>
                  <select class='form-control'  v-model="empleadoSelected">
                    <option value='0' >Todos los empleado</option>
                    <option v-for="rows in empleados" v-bind:value='rows.id_empleado'>{{ rows.nom_largo }}</option>
                  </select>

                </div>
              </div> 
            </div>
            <div class="col-sm-2"> 
              <button type="button" class="btn btn-info float-right"  @click='generateReport()'   >Ver Reporte</button>    
            </div>
            <div class="col-sm-2"> 
              <button type="button" class="btn btn-danger float-right"   @click='closeFrameReportView()'>Cerrar Reporte</button> 
            </div>
          </div> 
        </div><!-- container -->
      <!-- content -->
      </div>
      </div> 
      <!--  -->
    </div>
  </div>
  <br/>
  <div id="viewReport">
  </div>   
 </div> 
 <br/>  <br/>  <br/>
 
<script type="text/javascript" src="../js/admin/report.js" ></script>