var app_chagePassword = new Vue({
    el:'#chagePassword_DIV',
    data:{  
        modalchagePassword: false,
        pass_old : "",
        pass_new: "",
        pass_new_repeat:"", 
        id_empleado: "",
        disables_bte_save: false
    },
    methods:{ 
        showModal(id){  
            this.id_empleado = id; 
            this.modalchagePassword= true;this.disables_bte_save = false;
        },
        async managePassword(){  
           const isPassword_valid = await axios.post("../../php/login.php", {
                action:'comparePassword',password_old:this.pass_old
            }).then(function (response) { 
                if(response.data == 'contraseña válida'){return true;}else{return false;}; 
            })
            .catch(function (response) {  
                console.log(response);
                return false;
            });   
            if (isPassword_valid) { 
                if (this.pass_new != '' && this.pass_new_repeat != '') {
                    if (this.pass_new === this.pass_new_repeat) {
                        this.disables_bte_save = true; 
                       const result = await this.changePassword();
                       if (result == true){  
                            alert('¡Cambio de contraseña Exitoso!');   
                            location.href="../logout.php";   
                        }else
                            alert('La Contraseña NO se puede Actualizar en estos momentos.');  
                    }else{
                        alert('La Nueva cotraseña No coincide.');  
                    }
                }else{
                    alert('Ingresa la Nueva cotraseña y su comprobación.');  
                }
            }  else{
                alert('La contraseña anterio no coincide.');
            }
        },async changePassword(){
           return await axios.post("../../php/login.php", {
                action:'changePassword',password_old:this.pass_old, password_new: this.pass_new , id_empleado:this.id_empleado
            }).then(function (response) { 
                if(response.data == 'Password Updated'){return true;}else{console.log(response.data);return false;}; 
            })
            .catch(function (response) {  
                console.log(response);
                return false;
            });
        } 
    },
    async mounted() {       },
    created:function(){ 
        console.log("");

      }
   });  