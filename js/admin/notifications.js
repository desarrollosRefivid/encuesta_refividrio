
var notification = new Vue({
    el:'#notifications',
    data:{ 
        search_by: 0,
        allDataFilter: "",
        openModel:false,
        modalNotification:false,
        notificationSelected: '',
        allNotications:'',
        isCrud:false,
        actionButton:'Agregar',
        dynamicTitle:'Datos Empresa',
        hiddenId: null,
        countNotifications: "",  
        to_notify: [],
        data_to_filter:"",
        filter_value:"" 
    },
    methods:{
    newNotification() {   
        this.notificationSelected = {msg:"",description:"",id_notification:0};
        this.isCrud=true;
        this.getAllData();
    },  
    filter(){ 
        this.getDataFilter();  
        let array_result= [];
        this.data_to_filter.forEach(element => { 
            if (element.value.toUpperCase().includes(this.filter_value.toUpperCase())  ) { 
                array_result.push(element);
            } 
        });
        this.data_to_filter = array_result;
    },
   async getAllData(){
        const responce =  await axios.post('../php/notification/bd_notification.php', {  action:'getAllData' })
        .then(function(response){  return response.data;    });  
        this.allDataFilter = responce;
        console.log(responce);
    },
    getDataFilter(){ 
        switch (this.search_by) {
            case 'empresa': 
                this.data_to_filter =  this.allDataFilter[2];
                break; 
            case 'emp': 
                this.data_to_filter =  this.allDataFilter[1];
                break; 
            case 'org': 
                this.data_to_filter =  this.allDataFilter[0];
                break; 
            case 'all': 
                this.data_to_filter = [];
                break; 
            default:
                break;
        }
    },
    moveToFilter(value){
        let valid = true;
        this.to_notify.forEach(element => {
            if (element.id == value.id) {
                valid = false;
            }
        }); 
        if (valid) {
            this.to_notify.push(value);
            this.to_notify.reverse(); 
        }  
    },
    deleteToFilter(value){
        let array_result= [];
        for (let index = 0; index < this.to_notify.length; index++) {
            let element = this.to_notify[index]; 
            if (element.id != value.id) {
                array_result.push(element);
            }
        }
        this.to_notify = array_result; 
    },
    async showData(id_notification){ 
        this.allNotications.forEach(element => {
            if (element.id_notification == id_notification) { 
                this.notificationSelected= element ;  
                return;
            }
        });
        this.isCrud=true;
    },  
    save(){ 
        if (this.notificationSelected.id_notification > 0) {
            this.updateData();
        } else {
            this.createData();
        }
        this.data_to_filter = [];
        this.to_notify = [];
        this.search_by = 'all';
        this.filter_value = '';
    } ,
    async createData(){ 
        const responce =  await axios.post('../php/notification/bd_notification.php', {  action:'insertData', 
                                data: this.notificationSelected })
                         .then(function(response){  return response.data;});   
        if (responce.message == "Data Inserted") { 
            this.fetchAllNotifications();  
            this.isCrud=false;
        }  
        const responces =  await axios.post('../php/notification/bd_notification.php', {  
                             action:'insertNotification',  
                             id_notification: responce.id,
                             filter: this.to_notify
                            ,type: this.search_by })
        .then(function(response){  return response.data;});    
    },
    async updateData(){ 
        const responce =  await axios.post('../php/notification/bd_notification.php', {  action:'updateData', 
                                data: this.notificationSelected })
        .then(function(response){  return response.data;    });   
        if (responce.message == "Data Updated") { 
            this.fetchAllNotifications();  
            this.isCrud=false;
        }   
    }, 
    async deleteData(id_notification){ 
        const responce =  await axios.post('../php/notification/bd_notification.php', {  action:'deleteData',  id_notification: id_notification })
        .then(function(response){ return response.data; });   
        if (responce.message == "Data Deleteted") {  
        }  
        this.fetchAllNotifications();  
        this.isCrud=false;
    }, 
     async fetchAllNotifications(){
        const responce = await axios.post('../php/notification/bd_notification.php', {  action:'fetchallNotificationsAndmin'  }).then(function(response){   return response.data;   });   
        if (responce.length > 0 ) {
            notification.allNotications = responce;  
        } else{
            notification.allNotications = [];
        } 
     },  
    }, 
 
    mounted:function(){
        this.fetchAllNotifications(); 
        this.search_by = ""; 
    }
   });