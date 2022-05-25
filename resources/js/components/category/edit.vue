<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
            </ol>
         </div>
         <div class="row">
            <div class="">
               <!-- Form Basic -->
               <div class="card mb-4 ">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Add Category</h6>
                     <router-link to=/category class="btn btn-sms btn-primary">All Category</router-link>
                  </div>
                  <div class="card-body">
                     <form class="user" @submit.prevent="categoryUpdate">
                        <div class="form-group">
                           <div class="row">
                           	<div class="col-md-3"></div>
                              <div class="col">
                                 <label for="exampleInputEmail1">Category Name</label>
                                 <input type="text" class="form-control" placeholder="Enter Category Name" v-model="form.category_name">
                                 <small class="text-danger" v-if="errors.name"> {{ errors.category_name[0] }}</small>
                              </div>
                              <div class="col-md-3"></div>
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
              category_name: ''
           },
           errors:{}
        } 
     },
     created(){
     	let id = this.$route.params.id
     	axios.get('/api/category/' +id)
     	.then(({data}) =>(this.form = data))
     	.catch(console.log('error'))
     },
     methods:{
      categoryUpdate(){
      	 let id = this.$route.params.id
         axios.patch('/api/category/'+id,this.form)
         .then(() => {
          this.$router.push({ name: 'category'})
          Notification.success()
         })
         .catch(error =>this.errors = error.response.data.errors)
      },
     }
   
   
   }
</script>
<style type="text/css">
</style>