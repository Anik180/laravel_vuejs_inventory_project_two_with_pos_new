<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Product stock</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Edit Product stock</li>
            </ol>
         </div>
         <div class="row">
            <div class="">
               <!-- Form Basic -->
               <div class="card mb-4 ">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Edit Product stock</h6>
                     <router-link to=/stock class="btn btn-sms btn-primary">Stock</router-link>
                  </div>
                    <div class="card-body">
                     <form class="user" @submit.prevent="stockUpdate">
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputPassword1">Product Stock</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Product Quantity" v-model="form.qty">
                                 <small class="text-danger" v-if="errors.qty"> {{ errors.qty[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
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
              qty: ''
           },
           errors:{},
        } 
     },
     created(){
     	let id = this.$route.params.id
     	axios.get('/api/product/' +id)
     	.then(({data}) =>(this.form = data))
     	.catch(console.log('error'))
     },
     methods:{
      stockUpdate(){
      	 let id = this.$route.params.id
         axios.post('/api/stock/update/'+id,this.form)
         .then(() => {
          this.$router.push({ name: 'stock'})
          Notification.success()
         })
         .catch(error =>this.errors = error.response.data.errors)
      },
     }
   
   
   }
</script>
<style type="text/css">
</style>