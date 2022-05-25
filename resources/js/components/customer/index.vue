<template>
	<div>
		<div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">All Customer</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Customer</li>
              </ol>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  
                  <div >
                    <h6 class="d-inline m-0 font-weight-bold text-primary">Customer List</h6>
                    &nbsp;
                    <input type="text" v-model="searchTerm" name="" placeholder="Search">
                  </div>
                  
                  <router-link to=/store-customer class="btn btn-sms btn-primary">Add Customer</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Photo</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="customer in filterSearch" :key="customer.id">
                        <td>{{ customer.customer_name }}</td>
                        <td><img :src="customer.photo" id="sp_photo" ></td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.address }}</td>
                        <td>
                          <router-link :to="{name: 'edit-customer', params:{id:customer.id}}" class="btn btn-sm btn-primary"><i class="far fa-fw fa-edit"></i></router-link>
                          <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="color:white;"></i></a>
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
           customers:[],
           searchTerm:''
        } 
     },
     computed:{
      filterSearch(){
        return this.customers.filter(customer => {
          return customer.customer_name.match(this.searchTerm)
        })
      }
     },
     methods:{
        allCustomer(){
          axios.get('/api/customer/')
          .then(({data}) => (this.customers = data))
          .catch()
         },
        deleteCustomer(id){
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
            axios.delete('/api/customer/'+id)
            .then(() => {
              this.customers = this.supplieres.filter(customer => {
                return customer.id != id
              })
            })
            .catch(() => {
              this.$router.push({name: 'customer'})
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
       this.allCustomer();
     }
   
   
   }
</script>
<style type="text/css">
	#sp_photo{
    width: 40px; 
    height: 40px;
  }
</style>