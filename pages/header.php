<?php  
    session_start(); 
    $nombre = '';
    if (isset($_SESSION['rol'])) {
      if ($_SESSION['rol'] == 'admin')  {
        $nombre = $_SESSION['nombre']. ' '. $_SESSION['paterno']; 
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
      
      <li class="nav-item active">
        <a class="nav-link" href="logout.php">Salir <span class="sr-only">(current)</span></a>
      </li>
  </div>
</nav> 