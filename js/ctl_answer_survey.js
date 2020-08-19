var application = new Vue({
    el:'#usuarioencuesta',
    data:{ 
        questions:null 
        ,btePressed:true   
        ,cargando:true
    },
    methods:{
       async getRespuestas(){
            
            application.btePressed = true;
            let formValid = true;
            let validAnswers = []; 
            this.questions.forEach(pregunta => {
                if (pregunta.direct_data) {
                    let res = document.getElementById("res_" + pregunta.id_pregunta ).value;  
                    if ((res == '' || res == null) && pregunta.obligatoria) {
                        this.setColorLabel(pregunta.id_pregunta,"red");  
                        formValid = false;
                    } else {
                        this.setColorLabel(pregunta.id_pregunta,"black"); 
                        if (res != '' && res != null) {
                            validAnswers.push({"id_pregunta":pregunta.id_pregunta,"id_empleado":1,"id_opcion":null,"id_encuesta":pregunta.id_encuesta,"respuesta":res,"directa":1});
                        }
                    }  
                } else {
                    let arrayRespuestas = [] ;
                    pregunta.options.forEach(opcion => { 
                        if (document.getElementById(pregunta.id_pregunta + "_" + opcion.id_opcion).checked) {
                            arrayRespuestas.push({"respuesta": opcion.id_opcion });
                        }  
                    }); 
                    if (arrayRespuestas.length < 1  && pregunta.obligatoria) {
                        this.setColorLabel(pregunta.id_pregunta,"red");
                        formValid = false; 
                    } else {
                        this.setColorLabel(pregunta.id_pregunta,"black");
                        arrayRespuestas.forEach(element => { 
                          validAnswers.push({"id_pregunta":pregunta.id_pregunta,"id_empleado":1,"id_opcion":element.respuesta,"id_encuesta":pregunta.id_encuesta,"respuesta":null,"directa":0});
                        });
                    }  
                } 
            });  
            if (formValid) {
                await this.completeForm(validAnswers); 
            }else{
                alert("Responde a todas las Preguntas por favor.");   
                this.btePressed = false;
            } 
        },
        async completeForm(validAnswers){ 
            for (let index = 0; index < validAnswers.length; index++) {
                const respuesta = validAnswers[index];
                const result = await this.insertAnswer(respuesta); 
                console.log(result); 
            }  
            const result2 = await this.insertEmpleado_encuesta(validAnswers);  
            console.log(result2);  
            location.href="showPoll.php"; 
        },
        async insertEmpleado_encuesta(validAnswers){
            return axios.post("../../php/bd_answer_survey.php", { 
                action:'inserEncuesta_empleado'
                ,id_encuesta: validAnswers[0].id_encuesta     
            })
            .then(function (response) {   
                return response.data; 
            })
            .catch(function (response) {  
            return response.data;
            }) 
        },
        async insertAnswer(array_respuesta){
            return axios.post("../../php/bd_answer_survey.php", { 
                action:'insertAnswer'
                ,respuesta: array_respuesta
            })
            .then(function (response) {   
                return response.data; 
            })
            .catch(function (response) {  
            return response.data;
            })  
        },
        setColorLabel(id, color){
            document.getElementById("label_" + id ).style.color = color;
        },
        async getQuestions(id_encuesta){   
            let myArray ;
            const result = await this.seachQuestions(id_encuesta); 
            myArray = result; 
            for (let index = 0; index < myArray.length; index++) {
                const result = await this.seachOption(myArray[index].id_pregunta); 
                myArray[index]['options'] = result; 
            } 
            this.questions = myArray; 
        },
        seachQuestions:function(id_encuesta){
            return axios.post("../../php/bd_answer_survey.php", { 
                action:'fetchallQuestion'
                ,idEncuesta: id_encuesta
            })
            .then(function (response) {  
                return response.data; 
            })
            .catch(function (response) {  
            return response.data;
            })   
        },  
        seachOption:function(vidQuestion){
            return axios.post("../../php/bd_answer_survey.php", { 
                action:'fetchallOption',
                idQuestion: vidQuestion
            })
            .then(function (response) {   
                return response.data; 
            })
            .catch(function (response) {  
            return response.data;
            })   
        },
        async isValidPoll(id_encuesta){
            const valido =  await 
            axios.post("../../php/bd_answer_survey.php", { 
                action:'validPoll',
                id_encuesta: id_encuesta
            })
            .then(function (response) {   
                return response.data[0].encuesta_realizada; 
            })
            .catch(function (response) {  
            return response.data;
            })   
             return valido;
        } 
    },
    async mounted() {    
    },
    created: async function(){ 
        let id_encuesta = document.getElementById("id_encuesta").value; 
        if (id_encuesta > 0) {
            const valido = await this.isValidPoll(id_encuesta); ;
            if (!valido) {
                await this.getQuestions(id_encuesta); 
                this.btePressed = false;
                this.cargando = false;
            } else {
                alert("La encuesta ya no esta disponible.");
                location.href="showPoll.php"; 
            } 
        } else {
            location.href="showPoll.php"; 
        } 
    }
   }); 