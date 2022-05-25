<template>
	<div>
		<div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">All Product</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Product</li>
              </ol>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  
                  <div >
                    <h6 class="d-inline m-0 font-weight-bold text-primary">Product List</h6>
                    &nbsp;
                    <input type="text" v-model="searchTerm" name="" placeholder="Search">
                  </div>
                  
                  <router-link to=/store-product class="btn btn-sms btn-primary">Add Product</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Code</th>
                        <th>Root</th>
                        <th>Buying price</th>
                        <th>Selling price</th>
                        <th>Buying date</th>
                        <th>Qty</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="product in filterSearch" :key="product.id">
                        <td>{{ product.name }}</td>
                        <td><img :src="product.photo" id="prd_photo" ></td>
                        <td>{{ product.category_name }}</td>
                        <td>{{ product.supplier_name }}</td>
                        <td>{{ product.code }}</td>
                        <td>{{ product.root }}</td>
                        <td>{{ product.buying_price }}</td>
                        <td>{{ product.selling_price }}</td>
                        <td>{{ product.buying_date }}</td>
                        <td>{{ product.qty }}</td>
                        <td>
                          <router-link :to="{name: 'edit-product', params:{id:product.id}}" class="btn btn-sm btn-primary"><i class="far fa-fw fa-edit"></i></router-link>
                          <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="color:white;"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
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
           products:[],
           searchTerm:''
        } 
     },
     computed:{
      filterSearch(){
        return this.products.filter(product => {
          return product.code.match(this.searchTerm)
        })
      }
     },
     methods:{
        allProduct(){
          axios.get('/api/product/')
          .then(({data}) => (this.products = data))
          .catch()
         },
        deleteProduct(id){
           Swal.fire({
           title: 'Are you sure?',
           text: "You won't be able to revert this!",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
           }).then((result) => {
           if (result.value) {
            axios.delete('/api/product/'+id)
            .then(() => {
              this.products = this.products.filter(product => {
                return product.id != id
              })
            })
            .catch(() => {
              this.$router.push({name: 'product'})
            })
           Swal.fire(
             'Deleted!',
             'Your file has been deleted.',
             'success'
        )
          }
        })
        }
     },
     created(){
       this.allProduct();
     }
   
   
   }
</script>
<style type="text/css">
	#prd_photo{
    width: 40px; 
    height: 40px;
  }
</style>