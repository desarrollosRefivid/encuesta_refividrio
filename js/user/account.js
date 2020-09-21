

var account = new Vue({ 
    el:'#account',
    data:{
        account: '', 
    },
    methods:{ 
        async save(){
            if (this.validForm()) {
                const update_response = await axios.post('../../php/user/bd_account.php', {  action:'update',data:this.account }).then(function(response){ return  response.data });
                if (update_response.message == 'data update') {
                    this.fetchData(); 
                    alert("Datos actualizados."); 
                }else{
                    this.fetchData(); 
                    alert("Ocurrio un error:" + update_response.message);
                }
            } 
        },validarEmail(valor) {
            emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            if (emailRegex.test(valor)){
                return true;
            } else {
                return false;
            }
        },ValidateNumber(phoneNumber) {
            return !isNaN(parseFloat(phoneNumber)) && isFinite(phoneNumber);   
        },validarFormatoFecha(campo) {
           try {
               let date = new Date(campo); 
               if(date.getFullYear() > 1920 && date.getFullYear() < 2012){
                return true;
               }else{
                return false;
               } 
           } catch (error) {
               console.log(error);
               return false;
           }
        },validForm(){ 
            let valido = true;
            if ( this.validarFormatoFecha(this.account.fecha_nacimiento) == false ){
                document.getElementById("error_fecha_naci").innerHTML = "Tu fecha de Nacimiento es Incorrecta."
                valido = false;
            }else{
                document.getElementById("error_fecha_naci").innerHTML = "";
            }  
            if (this.validarEmail(this.account.correo) == false ){
                document.getElementById("error_correo").innerHTML = "Tu Correo es Incorrecto."
                valido = false;
            }else{
                document.getElementById("error_correo").innerHTML = "";
            }  
            
            if (this.ValidateNumber(this.account.celular) == false) {
                valido = false;
                document.getElementById("error_celular").innerHTML = "Tu Número celular es Incorrecto, Evita ingresar Paréntesis, espacios o cualquier Carácter que no sea un Número."
            }else{ 
                if(this.account.celular.length == 10){
                    document.getElementById("error_celular").innerHTML = ""
                }else{
                    document.getElementById("error_celular").innerHTML = "Tu Número celular es Incorrecto, Ingresar 10 Digitos."; 
                    valido = false;
                }
            }
            return valido;
        },async fetchData(){
            const account_response = await axios.post('../../php/user/bd_account.php', {  action:'fetchAccount' }).then(function(response){ return  response.data });
            this.account = account_response[0]; 
            console.log(this.account);
        } 
    }, 
    created:function(){
     this.fetchData(); 
    } 
 });