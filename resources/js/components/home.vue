<template>
	<div>
		
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="./">Home</a></li>
         <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
      </ol>
   </div>
   <div class="row mb-3">
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="row align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-uppercase mb-1">Today Sell</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800">${{ todaysell }}</div>
                  </div>
                  <div class="col-auto">
                     <i class="fas fa-calendar fa-2x text-primary"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Earnings (Annual) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-uppercase mb-1">Today Income</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800">{{ income }}</div>
                  </div>
                  <div class="col-auto">
                     <i class="fas fa-shopping-cart fa-2x text-success"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- New User Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-uppercase mb-1">Today Due</div>
                     <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ due }}</div>
                  </div>
                  <div class="col-auto">
                     <i class="fas fa-users fa-2x text-info"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Pending Requests Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-uppercase mb-1">Today Expense</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800">{{ expense }}</div>
                  </div>
                  <div class="col-auto">
                     <i class="fas fa-comments fa-2x text-warning"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

                 <div class="card">
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Code</th>
                        <th>Buying price</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="product in products" :key="product.id">
                        <td>{{ product.name }}</td>
                        <td><img :src="product.photo" id="prd_photo" ></td>
                        <td>{{ product.code }}</td>
                        <td>{{ product.buying_price }}</td>
                        <td v-if="product.qty >= 1 ">
                           <span class="badge badge-success">Available</span>
                        </td>
                        <td v-else=" ">
                           <span class="badge badge-danger">Stock Out</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
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
     return{
      todaysell:'',
      income:'',
      due:'',
      expense:'',
      products:''
     }
   },
   mounted(){
     this.todaySell();
     this.todayIncome();
     this.todayDue();
     this.todayExpense();
     this.stockOut();
   },
   methods:{
     todaySell(){
          axios.get('/api/today/sell')
         .then(({data}) =>(this.todaysell = data))
         .catch(error =>this.errors = error.response.data.errors)
     },
     todayIncome(){
          axios.get('/api/income')
         .then(({data}) =>(this.income = data))
         .catch(error =>this.errors = error.response.data.errors)
     },
      todayDue(){
          axios.get('/api/today/due')
         .then(({data}) =>(this.due = data))
         .catch(error =>this.errors = error.response.data.errors)
     },
      todayExpense(){
          axios.get('/api/today/expense')
         .then(({data}) =>(this.expense = data))
         .catch(error =>this.errors = error.response.data.errors)
     },

      stockOut(){
          axios.get('/api/today/stockout')
         .then(({data}) =>(this.products = data))
         .catch()
     }
   }

}
</script>
<style type="text/css">
	
</style>