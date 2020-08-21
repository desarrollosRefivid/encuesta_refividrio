

   var application_employee = new Vue({

    el:'#crudEmp',
    data:{
     allData_Emp:'',
     allDataComboCompany:'',
     myModel:false,
     myModelRol:false,
     actionButton:'Agregar',
     hiddenId:null,
     companys : null,
     pollSelected : null,
     isDisabledSC:true,
     dynamicTitle:'Datos Empleado',
     filterValue: ''
    },
    methods:{
     fetchAllData:function(){
      axios.post('../php/bd_employee.php', {
       action:'fetchall'
      }).then(function(response){
       application_employee.allData_Emp = response.data;
      });
     },

     fetchAllData_Company:function(){
      axios.post('../php/bd_company.php', {
       action:'fetchall'
      }).then(function(response){
       application_employee.allDataComboCompany = response.data;
         //alert(response.data.message);
         //console.log(response.data);
      } , function(){
      alert('No se han podido recuperar las empresas');


      });
     },
     

     fetchAllData_Org:function(){
      axios.post('../php/bd_organization.php', {
       action:'fetchall',
      }).then(function(response){
       application_employee.allDataCombo = response.data;
         //alert(response.data.message);
         //console.log(response.data);
      } , function(){
      alert('No se han podido recuperar las organizaciones');


      });
     }
    ,

     openModel:function(){
       application_employee.organization = '';
       application_employee.first_name = '';
       application_employee.paternal_name = '';
       application_employee.maternal_name = '';
       application_employee.cellphone = null;
       application_employee.emp_email = null;
       application_employee.age = '';
       application_employee.picked = '';
       application_employee.user = '';
       application_employee.checked = true;
       application_employee.checked_poll = true;
       application_employee.actionButton = "Agregar";
       application_employee.dynamicTitle = "Agregar Empleado";
       application_employee.myModel = true;
     },
     submitData:function(){
      if(application_employee.first_name != '' && application_employee.paternal_name != '' && application_employee.maternal_name != '')
      {
       if(application_employee.actionButton == 'Agregar')
       {
        axios.post('../php/bd_employee.php', {
         action:'insert',
         organization:application_employee.organization, 
         firstName:application_employee.first_name, 
         paternal_name:application_employee.paternal_name,
         maternal_name:application_employee.maternal_name,
         cellphone:application_employee.cellphone,
         emp_email:application_employee.emp_email,
         checked:application_employee.checked,
         checked_poll:application_employee.checked_poll,
         age:application_employee.age,
         picked:application_employee.picked

        }).then(function(response){
          application_employee.myModel = false;
          application_employee.fetchAllData();
          //application_employee.fetchAllData_Company();
          application_employee.organization = '';
          application_employee.first_name = '';
          application_employee.paternal_name = '';
          application_employee.maternal_name = '';
          application_employee.cellphone = null;
          application_employee.emp_email = null;
          application_employee.checked = '';
          application_employee.checked_poll = '';
          application_employee.age = '';
          application_employee.picked = '';          
          //console.log(response);
         alert(response.data.message);
        });
       }
       
       if(application_employee.actionButton == 'Actualizar')
       {
        axios.post('../php/bd_employee.php', {
         action:'update',
         organization : application_employee.organization,
         firstName : application_employee.first_name,
         paternal_name : application_employee.paternal_name,
         maternal_name : application_employee.maternal_name,
         cellphone : application_employee.cellphone,
         emp_email : application_employee.emp_email,
         checked : application_employee.checked,
         checked_poll : application_employee.checked_poll,
         age:application_employee.age,
         picked:application_employee.picked,
         user:application_employee.user,
         hiddenId : application_employee.hiddenId
        }).then(function(response){
          application_employee.myModel = false;
          application_employee.fetchAllData();
            //organization.fetchAllData_Company();
          application_employee.organization = '';
          application_employee.first_name = '';
          application_employee.paternal_name = '';
          application_employee.maternal_name = '';
          application_employee.cellphone = null;
          application_employee.emp_email = null;
          application_employee.checked = '';
          application_employee.checked_poll = '';
          application_employee.age = '';
          application_employee.picked = '';    
          application_employee.user = ''
          application_employee.hiddenId = '';
         alert(response.data.message);
        });
       }
      }
      else
      {
       alert("Favor de Completar el Formulario");
      }
     },

     filtrar(){
      axios.post('../php/bd_employee.php', {
        action:'filterEmpleado'
        ,filter:this.filterValue 
       }).then(function(response){
        application_employee.allData_Emp = response.data;
       });
     },
     fetchData:function(id){
      axios.post('../php/bd_employee.php', {
       action:'fetchSingle',
       id:id
      }).then(function(response){
       application_employee.organization = response.data.organization;
       application_employee.first_name = response.data.first_name;
       application_employee.paternal_name = response.data.paternal_name;
       application_employee.maternal_name = response.data.maternal_name;
       application_employee.cellphone = response.data.cellphone;
       application_employee.emp_email = response.data.emp_email
       application_employee.checked = response.data.checked
       application_employee.checked_poll = response.data.checked_poll
       application_employee.age = response.data.age
       application_employee.picked = response.data.picked
       application_employee.user = response.data.user
       application_employee.hiddenId = response.data.id;
       application_employee.myModel = true;
       application_employee.actionButton = 'Actualizar';
       application_employee.dynamicTitle = 'Editar Empleado';
      });
     },

     deleteData:function(id){
      if(confirm("¿Estas seguro de eliminar el registro?"))
      {
       axios.post('../php/bd_employee.php', {
        action:'delete',
        id:id
       }).then(function(response){
          application_employee.fetchAllData();
        //organization.fetchAllData_Company();

        alert(response.data.message);
       });
      }
     },

     async asingCompany(poll){ 
      this.isDisabledSC = false;
      this.pollSelected = poll;
      const response = await axios.post('../php/bd_employeerole.php', {  action:'fetchall',id_empleado:this.pollSelected.id_empleado }).then(function(response){ return  response.data });
      this.companys = response; 
      //console.log(this.companys);
      this.dynamicTitle = this.pollSelected.nombre;
      this.myModelRol = true;   
    },
    async saveCompanys(){ 
      this.isDisabledSC = true;
      const response = await axios.post('../php/bd_employeerole.php', {  action:'delete',id_empleado: this.pollSelected.id_empleado }).then(function(response){ return  response.data });
      // console.log(response); 
      for (let index = 0; index < this.companys.length; index++) {
        const element = this.companys[index];
        if (element.selected) { 
          const response2 = await axios.post('../php/bd_employeerole.php', {  action:'insert',id_empleado: this.pollSelected.id_empleado,id_rol: element.id_rol }).then(function(response){ return  response.data });
          // console.log(response2);
        } 
      } 
      this.pollSelected = null;
      this.myModelRol = false;   
    }


    },

    created:function(){
     this.fetchAllData();
     this.fetchAllData_Org();
     this.fetchAllData_Company();
    }

 });
