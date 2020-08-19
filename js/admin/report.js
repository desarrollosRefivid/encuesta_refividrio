// function generateReport() {
//     document.getElementById("viewReport").innerHTML =  '<center><iframe src="../php/generate_report.php/verReporte?p_descripciones=0&p_comerciaALL=0&p_imagenes=0" style="width:90%;height:700px;"></iframe></center>'; 
// }
// function closeFrameReportView(){
//     document.getElementById("viewReport").innerHTML = "";
// }  


var report = new Vue({
    el:'#reports',
    data:{ 
        empleados: "",
        companys : "",
        segments: "",
        pools: "",

        empleadoSelected: 0,
        empresaSelected: 0,
        segmentSelected: 0,
        pollSelected: 0,
        typePoolSelected:0
    },
    methods:{ 
       
        async getEmployeesBySegment(){ 
            this.modifiedContentdiv();  
            await axios.post("../php/bd_employee.php", {   action:'fetchByDepartament',   id_segmento: this.segmentSelected  })
            .then(function (response) {  console.log(response.data); report.empleados =  response.data;    })
            .catch(function (response) {    return response.data;  })   ;
            this.modifiedContentdiv();   
        } 
        ,async getCompanys(){ 
            const response =  await 
            axios.post("../php/bd_company.php", {  action:'fetchall',  })
            .then(function (response) {         return  response.data;   })
            .catch(function (response) {     return response.data; }) ; 
            return response;
            
        },
         async getSegments(){  
            this.modifiedContentdiv();  
            await 
            axios.post("../php/bd_organization.php", {   action:'fetchaByCompany',   id_empresa: this.empresaSelected,})
            .then(function (response) { report.segments = response.data;})
            .catch(function (response) { report.segments = response.data;  })   ;
            this.modifiedContentdiv();  
        },
        async getPools(){
            this.modifiedContentdiv();  
            await axios.post("../php/bd_poll.php", {   action:'fetchByType',   typePoolSelected: this.typePoolSelected,})
            .then(function (response) { report.pools = response.data;console.log(report.pools);})
            .catch(function (response) { report.pools = response.data;  }) ;  
            this.modifiedContentdiv();  
        },  
        generateReport() { 
            const url = "../php/generate_report.php/verReporte";
            let params = url ;
            params += "?id_encuesta=" + this.pollSelected;
            params += "&id_empleado=" + this.empleadoSelected;
            params += "&id_segmento=" + this.segmentSelected;  
            document.getElementById("viewReport").innerHTML =  '<center><iframe src=' + params +' style="width:90%;height:1150px;"></iframe></center>'; 
            document.getElementById("bteConsRes").click();
        },
        modifiedContentdiv(){ 
            document.getElementById("bteConsRes").click();
        }, 
        closeFrameReportView(){
            document.getElementById("viewReport").innerHTML = "";
        },
       
    },
    async mounted() {    
        
    },
    created: async function(){  
        this.modifiedContentdiv();  
        const response = await this.getCompanys(); ///this.getEmployeesBySegment(1);
        await this.getPools();
        this.companys = response; 
        this.modifiedContentdiv();  
    }
   }); 