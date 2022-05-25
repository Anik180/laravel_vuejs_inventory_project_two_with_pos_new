<template>
	<div>
		<div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">All Supplier</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Supplier</li>
              </ol>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  
                  <div >
                    <h6 class="d-inline m-0 font-weight-bold text-primary">Supplier List</h6>
                    &nbsp;
                    <input type="text" v-model="searchTerm" name="" placeholder="Search">
                  </div>
                  
                  <router-link to=/store-supplier class="btn btn-sms btn-primary">Add Supplier</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Supplier Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Shop Name</th>
                        <th>Photo</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="supplier in filterSearch" :key="supplier.id">
                        <td>{{ supplier.supplier_name }}</td>
                        <td><img :src="supplier.photo" id="sp_photo" ></td>
                        <td>{{ supplier.email }}</td>
                        <td>{{ supplier.phone }}</td>
                        <td>{{ supplier.address }}</td>
                        <td>{{ supplier.shop_name }}</td>
                        <td>
                          <router-link :to="{name: 'edit-supplier', params:{id:supplier.id}}" class="btn btn-sm btn-primary"><i class="far fa-fw fa-edit"></i></router-link>
                          <a href="#" class="btn btn-sm btn-info"><i class="far fa-fw fa-eye"></i></a>
                          <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="color:white;"></i></a>
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
           suppliers:[],
           searchTerm:''
        } 
     },
     computed:{
      filterSearch(){
        return this.suppliers.filter(supplier => {
          return supplier.supplier_name.match(this.searchTerm)
        })
      }
     },
     methods:{
        allSupplier(){
          axios.get('/api/supplier/')
          .then(({data}) => (this.suppliers = data))
          .catch()
         },
        deleteSupplier(id){
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
            axios.delete('/api/supplier/'+id)
            .then(() => {
              this.suppliers = this.supplieres.filter(supplier => {
                return supplier.id != id
              })
            })
            .catch(() => {
              this.$router.push({name: 'supplier'})
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
       this.allSupplier();
     }
   
   
   }
</script>
<style type="text/css">
	#sp_photo{
    width: 40px; 
    height: 40px;
  }
</style>