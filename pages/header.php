

<?php  
    session_start(); 
    $nombre = '';
    if (isset($_SESSION['rol'])) {
      if ($_SESSION['rol'] == 'admin')  {
        $nombre = $_SESSION['nombre']. ' '. $_SESSION['paterno'] . ' '. $_SESSION['materno'];  
      }else{
        header('location: ../');
      } 
    }else{
      header('location: ../');
    } 
  ?> 

  <title>Refividrio</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>    
  <link href="../css/modal.css" rel="stylesheet" type="text/css">
</head>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><img src="../img/logo.png" style="width:70%"></a>
  <span class="nav-link" style="color:#fff">
        
  </span>

  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> 
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    
      <li class="nav-item" style="color:#fff;">
      <a class="nav-link" href="#">
       <?php    
          echo $nombre; 
        ?> 
      </a>
      </li>  
      
    <li class="nav-item active">
        <a class="nav-link" href="p_company.php">Empresa <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="p_organization.php">Organizaci&oacute;n <span class="sr-only">(current)</span></a>
      </li>


    <li class="nav-item active">
        <a class="nav-link" href="p_employee.php">Empleado <span class="sr-only">(current)</span></a>
      </li>


      <li class="nav-item active">
        <a class="nav-link" href="p_poll.php">Encuesta <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="report.php">Reporte<span class="sr-only">(current)</span></a>
      </li>
      

      <div id='chagePassword_DIV'>   
          <li class="nav-item active">
            <button @click="showModal()" style="background:none;border:none;" > <a class="nav-link"   >Cambiar Contraseña<span class="sr-only">(current)</span></a></button>
          </li> 
          <div v-if="modalchagePassword" >  
              <transition name="model" >
                <div class="modal-mask" > 
                        <div class="modal-dialog modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"></h4>
                              <button type="button" class="close" @click="modalchagePassword=false"><span aria-hidden="true">&times;</span></button>
                            </div>  
                            <div class="modal-body"> 
                              <div class="card-body">   
                                  <div class="custom-control custom-checkbox">
                                    <h5 >Cambio de Contraseña.</h5> 

                                    <div class="form-group">
                                      <label>Contraseña Anterior</label>
                                      <input type="password" class="form-control" v-model="pass_old" />
                                    </div> 

                                    <div class="md-form md-outline input-with-post-icon datepicker">
                                      <label for="example">Nueva Contraseña</label>
                                      <input type="password" id="password_old" class="form-control" v-model="pass_new"  />
                                    </div> 

                                    <div class="md-form md-outline input-with-post-icon datepicker">
                                      <label for="example">Comprueba Contraseña</label>
                                      <input type="password" id="copy_validUntil" class="form-control" v-model="pass_new_repeat" />
                                    </div> 
                                    <br/><br/>
                                    
                                    <div align="center"> 
                                      <input type="button" class="btn btn-success btn-xs" value="Guardar" :disabled="disables_bte_save"  @click="managePassword(true)" />
                                    </div>
                                    
                                  </div>    
                                  </br> 
                              </div>
                            </div>
                        </div> 
                  </div>
                </div>
              </transition>
            </div>
          </div>
 

      <li class="nav-item active">
        <a class="nav-link" href="logout.php">Salir <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item active">
        
      </li>
      
  </div>
</nav> 

<script type="text/javascript" src="../js/admin/changePasword.js"></script>  