<?php    
    session_start(); 
    $nombre = ''; $id_empleado = ''; 
    if (isset($_SESSION['rol'])) {
      if ($_SESSION['rol'] == 'user')  {
        $nombre = $_SESSION['nombre']. ' '. $_SESSION['paterno'] . ' '. $_SESSION['materno'];  
      }else{  header('location: ../');  } 
    }else{ header('location: ../'); } 
?> 

<head>
  <title>Refividrio</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/styleDinamicControl.css"> 
  <link rel="stylesheet" href="../../css/modal.css"> 
  <link rel="stylesheet" href="../../css/notificaciones.css"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>  
  <link rel="icon" href="http://collectivecloudperu.com/blogdevs/wp-content/uploads/2017/09/cropped-favicon-1-32x32.png">
</head> 
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
  <a class="navbar-brand" href="#"><img src="../../img/logo.png" style="width:70%"></a> 
  <span class="nav-link" style="color:#fff"><?php  echo $nombre; ?></span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> 
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="showPoll.php">Ver Encuestas <span class="sr-only">(current)</span></a>
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
                              </div><br/><br/>
                              <div align="center"> 
                                <input type="button" class="btn btn-success btn-xs" value="Guardar" :disabled="disables_bte_save"  @click="managePassword(false)" />
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
 
    <li class="nav-item active">        <!-- notificaciones -->
      <div id="notification">  
        <div class="demo-content">
          <div id="notification-header">
            <div style="position:relative">
              <button id="notification-icon" name="button"  @click="showNotifications()" class="dropbtn"><span id="notification-count">{{ countNotifications }}</span><img src="../../img/notificacions.png" width=35px; /></button>
                <div id="notification-latest" v-if="myModel" >  
                  <div v-for="item in allNotications">  
                        <div class='notification-item container-fluid'  v-bind:class="[item.viewed ? '': 'viewed']" 
                              @click="viewNotification(item.id_notification_detail,item.viewed)" >
                          <div>  <strong> {{ item.msg }} </strong>  </div> 
                          <div class='container-fluid'> {{ item.description.substring(0,160) }}  </div> 
                        </div> 
                  </div> 
                </div>
            </div>
          </div>          
        </div>                          <!-- notificaciones -->

        <div v-if="modalNotification" >  <!-- Modal notificaciones -->
          <transition name="model" >
            <div class="modal-mask" > 
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title"></h4>
                          <button type="button" class="close" @click="modalNotification=false;notificationSelected='';"><span aria-hidden="true">&times;</span></button>
                        </div>  
                        <div class="modal-body"> 
                          <div class="card-body">   
                              <div class="custom-control custom-checkbox">
                                <h3> {{ notificationSelected.msg }} </h3> 
                                <p> {{ notificationSelected.description }} </p>
                              </div>    
                              </br> 
                          </div>
                        </div>
                    </div> 
              </div>
            </div>
          </transition>
        </div>                          <!-- Modal notificaciones -->
  
      </div>   
    </li> 
 
    <li class="nav-item active">
      <a class="nav-link" href="../logout.php">Salir <span class="sr-only">(current)</span></a>
    </li> 
  </div>
   
</nav>  
<script type="text/javascript" src="../../js/admin/changePasword.js"></script>  
<script type="text/javascript" src="../../js/user/notifications.js"></script>
