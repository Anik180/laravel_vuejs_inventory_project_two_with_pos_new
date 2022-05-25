<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Customer</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="./">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Add Customer</li>
            </ol>
         </div>
         <div class="row">
            <div class="">
               <!-- Form Basic -->
               <div class="card mb-4 ">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Add Customer</h6>
                     <router-link to=/customer class="btn btn-sms btn-primary">All Customer</router-link>
                  </div>
                  <div class="card-body">
                     <form class="user" @submit.prevent="customerInsert" enctype="multipart/form-data">
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputEmail1">Customer Name</label>
                                 <input type="text" class="form-control" placeholder="Enter Customer Name" v-model="form.customer_name">
                                 <small class="text-danger" v-if="errors.customer_name"> {{ errors.customer_name[0] }}</small>
                              </div>
                              <div class="col">
                                 <label for="exampleInputEmail1">Email</label>
                                 <input type="email" class="form-control" placeholder="Enter Email" v-model="form.email">
                                 <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputPassword1">Phone</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Phone" v-model="form.phone">
                                 <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }}</small>
                              </div>
                              <div class="col">
                                 <label for="exampleInputPassword1">Address</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Address" v-model="form.address">
                                 <small class="text-danger" v-if="errors.address"> {{ errors.address[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputPassword1">Photo</label>
                                 <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }}</small>
                                 </div>
                              </div>
                              <div>
                                <img :src="form.photo" style="height: 40px; width: 40px; float: right;">
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <!--Row-->
      </div>
   </div>
</template>
<script type="text/javascript">
   export default{
     created(){
       if(!User.loggedIn()) {
         this.$router.push({ name: '/'})
       }
     },
     data(){
        return {
           form:{
              customer_name: null,
              email: null,
              phone: null,
              address: null,
              photo: null
           },
           errors:{}
        } 
     },
     methods:{
      onFileSelected(event){
        let file = event.target.files[0];
        if (file.size > 1048770) {
          Notification.image_validation()
        }else{
          let reader = new FileReader();
          reader.onload = event =>{
            this.form.photo = event.target.result
            console.log(event.target.result);
          };
          reader.readAsDataURL(file);
        }
      },
      customerInsert(){
         axios.post('/api/customer',this.form)
         .then(() => {
          this.$router.push({ name: 'customer'})
          Notification.success()
         })
         .catch(error =>this.errors = error.response.data.errors)
      },
     }
   
   
   }
</script>
<style type="text/css">
</style>