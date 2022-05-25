<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Order Details</li>
            </ol>
         </div>
         <div class="row">
            <div class="">
               <!-- Form Basic -->
               <div class="card mb-4 ">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                     <router-link to=/order class="btn btn-sms btn-primary">Go Back</router-link>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-lg-6 mb-4">
                           <!-- Simple Tables -->
                           <div class="card">
                              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                 <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                              </div>
                              <div class="table-responsive">
                                 <ul class="list-group">
                                    <li class="list-group-item"><b>Name :</b>{{ orders.customer_name }}</li>
                                    <li class="list-group-item"><b>Phone :</b>{{ orders.phone }}</li>
                                    <li class="list-group-item"><b>Email :</b>{{ orders.email }}</li>
                                    <li class="list-group-item"><b>Address :</b>{{ orders.address }}</li>
                                    <li class="list-group-item"><b>Date :</b>{{ orders.date }}</li>
                                    <li class="list-group-item"><b>Pay By :</b>{{ orders.payBy }}</li>
                                 </ul>
                              </div>
                              <div class="card-footer"></div>
                           </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                           <!-- Simple Tables -->
                           <div class="card">
                              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                 <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                              </div>
                              <div class="table-responsive">
                                 <ul class="list-group">
                                    <li class="list-group-item"><b>Sub Total :</b>{{ orders.subTotal }}</li>
                                    <li class="list-group-item"><b>Total :</b>{{ orders.total }}</li>
                                    <li class="list-group-item"><b>Qty :</b>{{ orders.qty }}</li>
                                    <li class="list-group-item"><b>Vat :</b>{{ orders.vat }}%</li>
                                    <li class="list-group-item"><b>Pay :</b>{{ orders.pay }}</li>
                                    <li class="list-group-item"><b>Due :</b>{{ orders.due }}</li>
                                 </ul>
                              </div>
                              <div class="card-footer"></div>
                           </div>
                        </div>
                     </div>
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
                                          <th>Product Name</th>
                                          <th>Product Code</th>
                                          <th>Photo</th>
                                          <th>Qty</th>
                                          <th>Unit Price</th>
                                          <th>Total</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr v-for="detail in details">
                                          <td>{{ detail.name}}</td>
                                          <td>{{ detail.code}}</td>
                                          <td><img :src="'/'+detail.photo" id="prd_photo" ></td>
                                          <td>{{ detail.od_qty}}</td>
                                          <td>{{ detail.od_price}}</td>
                                          <td>{{ detail.sub_total}}</td>
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
   
           errors:{},
           orders:{},
           details:{},
   
        } 
     },
     created(){
      let id = this.$route.params.id
      axios.get('/api/allorder/' +id)
      .then(({data}) =>(this.orders = data))
      .catch(console.log('error'))
   
       axios.get('/api/order/details/' +id)
      .then(({data}) =>(this.details = data))
      .catch(console.log('error'))
   
   
     },
     methods:{
       
     }
   
   
   }
</script>
<style type="text/css">
   #prd_photo{
   width: 40px; 
   height: 40px;
   }
</style>