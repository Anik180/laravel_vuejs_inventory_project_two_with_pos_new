<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
         </div>
         <div class="row">
            <div class="">
               <!-- Form Basic -->
               <div class="card mb-4 ">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
                     <router-link to=/product class="btn btn-sms btn-primary">All Product</router-link>
                  </div>
                                    <div class="card-body">
                     <form class="user" @submit.prevent="productUpdate" enctype="multipart/form-data">
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                    <label for="exampleFormControlSelect1">Product Category</label>
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.category_id" >
                                       <option :value="category.id" v-for="category in categories" >{{ category.category_name }}</option>
                                    </select>
                              </div>
                              <div class="col">
                                    <label for="exampleFormControlSelect1">Product Supplier</label>
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id">

                                       <option :value="supplier.id" v-for="supplier in suppliers">{{ supplier.supplier_name }}</option>
                                    </select>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputPassword1">Product Name</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Product Name" v-model="form.name">
                                 <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }}</small>
                              </div>
                              <div class="col">
                                 <label for="exampleInputPassword1">Product Code</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Product Code" v-model="form.code">
                                 <small class="text-danger" v-if="errors.code"> {{ errors.code[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputPassword1">Product Root</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Product Root" v-model="form.root">
                                 <small class="text-danger" v-if="errors.root"> {{ errors.root[0] }}</small>
                              </div>
                              <div class="col">
                                 <label for="exampleInputPassword1">Buying Price</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Buying Price" v-model="form.buying_price">	
                                 <small class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputPassword1">Selling Price</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Selling Price" v-model="form.selling_price">
                                 <small class="text-danger" v-if="errors.selling_price"> {{ errors.selling_price[0] }}</small>
                              </div>
                              <div class="col">
                                 <label for="exampleInputPassword1">Buying Date</label>
                                 <input type="date" class="form-control" id="exampleInputPassword1" placeholder="Enter Buying Date" v-model="form.buying_date">
                                 <small class="text-danger" v-if="errors.buying_date"> {{ errors.buying_date[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputPassword1">Product Quantity</label>
                                 <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Product Quantity" v-model="form.qty">
                                 <small class="text-danger" v-if="errors.qty"> {{ errors.qty[0] }}</small>
                              </div>
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
              category_id: '',
              supplier_id: '',
              name: '',
              code: '',
              root: '',
              buying_price: '',
              selling_price: '',
              buying_date: '',
              photo: '',
              newphoto:'',
              qty: ''
           },
           errors:{},
           categories:{},
           suppliers:{},
        } 
     },
     created(){
     	let id = this.$route.params.id
     	axios.get('/api/product/' +id)
     	.then(({data}) =>(this.form = data))
     	.catch(console.log('error'))

     	axios.get('/api/category/')
        .then(({data}) => (this.categories = data))

        axios.get('/api/supplier/')
       .then(({data}) => (this.suppliers = data))
     },
     methods:{
      onFileSelected(event){
        let file = event.target.files[0];
        if (file.size > 1048770) {
          Notification.image_validation()
        }else{
          let reader = new FileReader();
          reader.onload = event =>{
            this.form.newphoto = event.target.result
          };
          reader.readAsDataURL(file);
        }
      },
      productUpdate(){
      	 let id = this.$route.params.id
         axios.patch('/api/product/'+id,this.form)
         .then(() => {
          this.$router.push({ name: 'product'})
          Notification.success()
         })
         .catch(error =>this.errors = error.response.data.errors)
      },
     }
   
   
   }
</script>
<style type="text/css">
</style>