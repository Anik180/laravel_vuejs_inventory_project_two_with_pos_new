<template>
  <div>
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">Today Order</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Today Order</li>
              </ol>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  
                  <div >
                    <h6 class="d-inline m-0 font-weight-bold text-primary">Today Order</h6>
                    &nbsp;
                    <input type="text" v-model="searchTerm" name="" placeholder="Search">
                  </div>
                  
                  <router-link to=/home class="btn btn-sms btn-primary">Go Back</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Pay</th>
                        <th>Due</th>
                        <th>Pay By</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in filterSearch" :key="order.id">
                        <td>{{ order.customer_name }}</td>
                        <td>{{ order.total }}</td>
                        <td>{{ order.pay }}</td>
                        <td>{{ order.due }}</td>
                        <td>{{ order.payBy }}</td>
                        <td>
                          <router-link :to="{name: 'view-order', params:{id:order.id}}" class="btn btn-sm btn-primary"><i class="far fa-fw fa-eye"></i></router-link>
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
           orders:[],
           searchTerm:''
        } 
     },
     computed:{
      filterSearch(){
        return this.orders.filter(order => {
          return order.customer_name.match(this.searchTerm)
        })
      }
     },
     methods:{
        allOrder(){
          axios.get('/api/order/')
          .then(({data}) => (this.orders = data))
          .catch()
         },
        
     },
     created(){
       this.allOrder();
     }
   
   
   }
</script>
<style type="text/css">
  #em_photo{
    width: 40px; 
    height: 40px;
  }
</style>