<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Search</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Search</li>
            </ol>
         </div>
         <div class="row">
            <div class="">
               <!-- Form Basic -->
               <div class="card mb-4 ">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Search</h6>
                     <router-link to=/today-order class="btn btn-sms btn-primary">Today Order</router-link>
                  </div>
                  <div class="card-body">
                     <form class="user" @submit.prevent="searchDate">
                        <div class="form-group">
                           <div class="row">
                            <div class="col-md-3"></div>
                              <div class="col">
                                 <label for="exampleInputEmail1">Search By Date</label>
                                 <input type="date" class="form-control" required="" v-model="date">
                              </div>
                              <div class="col-md-3"></div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Search</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <!--Row-->
                              <div class="row">
                        <div class="col-lg-12 mb-4">
                           <!-- Simple Tables -->
                           <div class="card">
                              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                 <h6 class="m-0 font-weight-bold text-primary">Details</h6>
                              </div>
                              <div class="table-responsive">
                                 <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                       <tr>
                                          <th>Customer Name</th>
                                          <th>Qty</th>
                                          <th>Vat</th>
                                          <th>Sub Total</th>
                                          <th>Total</th>
                                          <th>Pay</th>
                                          <th>Due</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr v-for="order in orders">
                                          <td>{{ order.customer_name}}</td>
                                          <td>{{ order.qty}}</td>
                                          <td>{{ order.vat}}</td>
                                          <td>{{ order.subTotal}}</td>
                                          <td>{{ order.total}}</td>
                                          <td>{{ order.pay}}</td>
                                          <td>{{ order.due}}</td>
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

           date:'',
           orders:{}
        } 
     },
     methods:{
      searchDate(){
        var data = {date:this.date}
         axios.post('/api/search',data)
         .then(({data}) =>(this.orders = data))
         .catch(error =>this.errors = error.response.data.errors)
      },
     }
   
   
   }
</script>
<style type="text/css">
</style>