<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="./">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
         </div>
         <div class="row mb-3">
            <!-- Area Chart -->
            <div class="col-xl-5 col-lg-5">
               <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                     <a class="btn btn-sm btn-info" style="color: white;">Add Customer</a>
                  </div>

      <div class="table-responsive" style="font-size:12px; ">
         <table class="table align-items-center table-flush">
            <thead class="thead-light">
               <tr>
                  <th>Name</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>Total</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <tr  v-for="cart in carts" :key="cart.id">
                  <td>{{ cart.p_name.substring(0,10)+".." }}</td>
                  <td>
                    <input type="text" readonly="" style="width: 25px; height: 30px;" :value="cart.p_qty">
                    <button @click.prevent="increment(cart.id)" class="btn btn-sm btn-success"><i class="fa fa-plus" style="color: white;"></i></button>
                    <button @click.prevent="decrement(cart.id)" class="btn btn-sm btn-danger" v-if="cart.p_qty >= 2"><i class="fa fa-minus" style="color: white;"></i></button>
                    <button class="btn btn-sm btn-danger" v-else="" disabled=""><i class="fa fa-minus" style="color: white;"></i></button>

                  </td>
                  <td>{{ cart.p_price }}</td>
                  <td>{{ cart.sub_total }}</td>
                  <td><a @click="removeItem(cart.id)" class="btn btn-sm btn-primary"><i class="fa fa-trash" style="color: white;"></i></a></td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="card-footer">
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">Total Quantity: 
            <strong>{{ qty }}</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">Sub Total: 
            <strong>{{ subTotal }}<b>৳</b></strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">Vat: 
            <strong>{{ vats.vat }}%</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">Total: 
            <strong>{{ subTotal*vats.vat /100  +subTotal}}<b>৳</b></strong>
          </li>

        </ul>
        <br>
        <form @submit.prevent="orderDone">
          <label>Customer Name</label>
          <select class="form-control" v-model="customer_id">
          <option :value="customer.id" v-for="customer in customers">{{ customer.customer_name }}</option>
          </select>

          <label>Pay</label>
          <input type="text" class="form-control" required="" v-model="pay">

          <label>Due</label>
          <input type="text" class="form-control" required="" v-model="due">

          <label>Pay By</label>
          <select class="form-control" v-model="payBy">
          <option value="Handcash">Hand Cash</option>
          <option value="Cheaque">Cheaque</option>
          <option value="GiftCard">Gift Card</option>
          </select>
          <br>
          <button type="submit" class="btn btn-success">Submit</button>
        </form>
      </div>

            </div>
          </div>
            <!-- Pie Chart -->
            <div class="col-xl-7 col-lg-7">
               <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Products</h6>
                  </div>
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Products</button>
                     </li>
                     <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" @click="subProduct(category.id)">{{ category.category_name }}</button>
                     </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-body">
                           <div>
                              <input type="text" v-model="searchTerm" class="form-control" placeholder="Search Products" style="width: 643px; margin-bottom: 5px;">
                           </div>
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filterSearch" :key="product.id">
                                 <button class="btn btn-sm" @click.prevent="addToCart(product.id)">
                                    <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                       <img :src="product.photo" id="prd_photo" class="card-img-top" >
                                       <div class="card-body">
                                          <h6 class="card-title">{{ product.name.substring(0,10)+".." }}</h6>
                                          <span>Code: {{ product.code }}</span>
                                          <span class="badge badge-success" v-if="product.qty >= 1 ">Available {{ product.qty }}
                                          </span>
                                          <span class="badge badge-danger" v-else=" ">Stock Out</span>
                                       </div>
                                    </div>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card-body">
                           <div>
                              <input type="text" v-model="getSearchTerm" class="form-control" placeholder="Search Products" style="width: 643px; margin-bottom: 5px;">
                           </div>
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getproduct in getFilterSearch" :key="getproduct.id">
                                 <button class="btn btn-sm" @click.prevent="addToCart(getproduct.id)">
                                    <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                       <img :src="getproduct.photo" id="prd_photo" class="card-img-top" >
                                       <div class="card-body">
                                          <h6 class="card-title">{{ getproduct.name.substring(0,10)+".." }}</h6>
                                          <span>Code: {{ getproduct.code }}</span>
                                          <span class="badge badge-success" v-if="getproduct.qty >= 1 ">Available {{ getproduct.qty }}
                                          </span>
                                          <span class="badge badge-danger" v-else=" ">Stock Out</span>
                                       </div>
                                    </div>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
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
    created(){
      this.allProduct();
      this.allCategory();
      this.allCustomer();
      this.cartProduct();
      this.vat();
      Reload.$on('afterAdd',() =>{
      this.cartProduct();
      })
    },
    data(){
       return {
          customer_id:'',
          pay:'',
          due:'',
          payBy:'',


          products:[],
          categories:'',
          getproducts:[],
          searchTerm:'',
          getSearchTerm:'',
          customers:'',
          errors:'',
          carts:[],
          vats:''
       } 
    },
    computed:{
     filterSearch(){
       return this.products.filter(product => {
         return product.code.match(this.searchTerm)
       })
     },
     getFilterSearch(){
       return this.getproducts.filter(getproduct => {
         return getproduct.code.match(this.getSearchTerm)
       })
     },
     qty(){
      let sum = 0;
      for(let i = 0; i < this.carts.length; i++){
        sum += (parseFloat(this.carts[i].p_qty));
      }
      return sum;
     },
     subTotal(){
      let sum = 0;
      for(let i = 0; i < this.carts.length; i++){
        sum += (parseFloat(this.carts[i].p_qty) * parseFloat(this.carts[i].p_price));
      }
      return sum;
     }
    },
    methods:{
      addToCart(id){
         axios.get('/api/addToCart/'+id)
         .then(() => {
          Reload.$emit('afterAdd');
           Notification.cart_success()
         })
         .catch()
      },
      cartProduct(){
          axios.get('/api/cart/product/')
         .then(({data}) => (this.carts = data))
         .catch()
      },
      removeItem(id){
          axios.get('/api/remove/Cart/'+id)
         .then(() => {
          Reload.$emit('afterAdd');
           Notification.cart_remove()
         })
         .catch()
      },
      increment(id){
          axios.get('/api/increment/'+id)
         .then(() => {
          Reload.$emit('afterAdd');
           Notification.success()
         })
         .catch()
      },
      decrement(id){
          axios.get('/api/decrement/'+id)
         .then(() => {
          Reload.$emit('afterAdd');
           Notification.success()
         })
         .catch()
      },
      vat(){
          axios.get('/api/vat/')
         .then(({data}) => (this.vats = data))
         .catch()
      },
      orderDone(){
       let total = this.subTotal*this.vats.vat /100 + this.subTotal;
       var data = {
         qty:this.qty,
         vat:this.vats.vat,
         subTotal:this.subTotal,
         total:total,
         customer_id:this.customer_id,
         pay:this.pay,
         due:this.due,
         payBy:this.payBy

       }
          axios.post('/api/orderDone',data)
         .then(() => {
          Notification.success()
         })
      },
       allProduct(){
         axios.get('/api/product/')
         .then(({data}) => (this.products = data))
         .catch()
        },
        allCategory(){
         axios.get('/api/category/')
         .then(({data}) => (this.categories = data))
         .catch()
        },
        allCustomer(){
         axios.get('/api/customer/')
         .then(({data}) => (this.customers = data))
         .catch(console.log('error'))
        },
        subProduct(id){
         axios.get('/api/get/product/'+id)
         .then(({data}) => (this.getproducts = data))
         .catch()
        },
    },
   
   
   }
</script>
<style type="text/css" scoped>
   #prd_photo{
   width: 90px; 
   height: 135px;
   }
</style>