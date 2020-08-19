var login = new Vue({
    el:'#login',
    data:{  
        roles: null 
    },
    methods:{ 
        seachUser:async function(){ 
            let userParam = document.getElementById("user").value;
            let passwordParam = document.getElementById("password").value;
            let rolParam = document.getElementById("rol").value; 
            this.roles != null && this.roles != '' && rolParam != '' ?  rolParam = this.roles[rolParam]   : rolParam = 0;  
            
            try {
                   
                    const sig = await this.getRols(userParam,passwordParam ,rolParam); 
                    if (sig != null) { 
                            if (sig != "succes")  {  
                                if (sig.includes("¡Error!")) { 
                                    console.log("2");
                                    document.getElementById("msg").style.display = "none"; 
                                    document.getElementById("msgErro").innerHTML = sig; 
                                    document.getElementById("msgErro").style.display = "block"; 
                                    document.getElementById("buttonCancel").style.display = "none"; 
                                }else{ 
                                    console.log("3");
                                    login.roles = sig;
                                    var x = document.getElementById("rol"); 
                                    for (let index = 0; index <  this.roles.length; index++) { 
                                        const element =  this.roles[index];
                                        var option = document.createElement("option");
                                        option.text = element.rol; option.value = index;
                                        x.add(option);
                                        x.style.display = "block"; 
                                    } 
                                    document.getElementById("msg").innerHTML = "Selecciona un Rol"; 
                                    document.getElementById("msg").style.display = "block"; 
                                    document.getElementById("msgErro").style.display = "none";
                                    document.getElementById("user").disabled  = true; 
                                    document.getElementById("password").disabled  = true;
                                    document.getElementById("buttonCancel").style.display = "block";
                                } 
                            } else {
                                if (rolParam.rol == 'admin') {
                                    location.href="pages/p_poll.php";  
                                } else if (rolParam.rol == 'user'){
                                    location.href="pages/user/showPoll.php"; 
                                }
                            }     
                        }else{
                            document.getElementById("msg").style.display = "none"; 
                            document.getElementById("msgErro").innerHTML = "Comprueba tus credenciales "; 
                            document.getElementById("msgErro").style.display = "block"; 
                            document.getElementById("buttonCancel").style.display = "none"; 
                        }
                } catch (error) { 
                    document.getElementById("msg").style.display = "none"; 
                    document.getElementById("msgErro").innerHTML = "Comprueba tus credenciales " + error; 
                    document.getElementById("msgErro").style.display = "block"; 
                    document.getElementById("buttonCancel").style.display = "none"; 
                } 
        }, 
        reset(){  location.href="pages/logout.php";   },
        async getRols(userParam,passwordParam,rolParam ){
            if (userParam != '' && passwordParam != '') { 
               return axios.post("php/login.php", {user:userParam,password:passwordParam,rol:rolParam
                }).then(function (response) { 
                    return this.roles = response.data;   
                })
                .catch(function (response) {  
                    console.log(response); 
                })     
            } else {
                document.getElementById("msg").style.display = "none";  
                document.getElementById("msgErro").innerHTML = "Ingresa tus credenciales"; 
                document.getElementById("msgErro").style.display = "block"; 
                document.getElementById("buttonCancel").style.display = "none"; 
            } 
        } 
    },
    async mounted() {   this.roles= null   },
    created:function(){  this.roles= null  }
   });  