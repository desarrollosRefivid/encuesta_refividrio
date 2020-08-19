
var application = new Vue({
    el:'#crudApp',
    data:{
     allData:'',
     myModel:false,
     actionButton:'Agregar',
     dynamicTitle:'Datos Empresa',
     hiddenId: null,
    },
    methods:{
     fetchAllData:function(){
      axios.post('../php/bd_company.php', {
       action:'fetchall'
      }).then(function(response){
       application.allData = response.data;

      });
     },
     openModel:function(){
      application.first_name = '';
      application.last_name = '';
      application.checked = true;
      application.actionButton = "Agregar";
      application.dynamicTitle = "Agregar Empresa";
      application.myModel = true;
     },
     submitData:function(){
      if(application.first_name != '' )
      {
       if(application.actionButton == 'Agregar')
       {
        axios.post('../php/bd_company.php', {
         action:'Agregar',
         firstName:application.first_name, 
         lastName:application.last_name,
         checked:application.checked
        }).then(function(response){
         application.myModel = false;
         application.fetchAllData();
         application.first_name = '';
         application.last_name = '';
         application.checked = '';
         alert(response.data.message);
        });
       }
       if(application.actionButton == 'Modificar')
       {
        axios.post('../php/bd_company.php', {
         action:'Modificar',
         firstName : application.first_name,
         lastName : application.last_name,
         checked : application.checked,
         hiddenId : application.hiddenId
        }).then(function(response){
         application.myModel = false;
         application.fetchAllData();
         application.first_name = '';
         application.last_name = '';
         application.checked = '';
         application.hiddenId = '';
         alert(response.data.message);
        });
       }
      }
      else
      {
       alert("Favor de llenar los campos del formulario");
      }
     },
     fetchData:function(id){
      axios.post('../php/bd_company.php', {
       action:'fetchSingle',
       id:id
      }).then(function(response){
       application.first_name = response.data.first_name;
       application.last_name = response.data.last_name;
       application.checked = response.data.checked;
       application.hiddenId = response.data.id;
       application.myModel = true;
       application.actionButton = 'Modificar';
       application.dynamicTitle = 'Editar Empresa';
      });
     },
     deleteData:function(id){
      if(confirm("¿Estas seguro de eliminar el registro?"))
      {
       axios.post('../php/bd_company.php', {
        action:'delete',
        id:id
       }).then(function(response){
        application.fetchAllData();
        alert(response.data.message);
       });
      }
     }
    },
    created:function(){
     this.fetchAllData();
    }
   });