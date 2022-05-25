<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Expense</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="./">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Add Expense</li>
            </ol>
         </div>
         <div class="row">
            <div class="">
               <!-- Form Basic -->
               <div class="card mb-4 ">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Add Expense</h6>
                     <router-link to=/expense class="btn btn-sms btn-primary">All Expense</router-link>
                  </div>
                  <div class="card-body">
                     <form class="user" @submit.prevent="expenseInsert">
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputEmail1">Expense Amount</label>
                                 <input type="text" class="form-control" placeholder="Enter Expense Amount" v-model="form.amount">
                                 <small class="text-danger" v-if="errors.amount"> {{ errors.amount[0] }}</small>
                              </div>
                              <div class="col">
                                 <label for="exampleInputEmail1">Expense Date</label>
                                 <input type="date" class="form-control" placeholder="Enter Expense Date" v-model="form.date">
                                 <small class="text-danger" v-if="errors.date"> {{ errors.date[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputEmail1">Expense Detail</label>
                                 <textarea type="text" class="form-control" placeholder="Enter Expense Detail" v-model="form.details"></textarea>
                                 <small class="text-danger" v-if="errors.details"> {{ errors.details[0] }}</small>
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
              details: null,
              amount: null,
              date: null
           },
           errors:{},
        } 
     },
     methods:{
      expenseInsert(){
         axios.post('/api/expense',this.form)
         .then(() => {
          this.$router.push({ name: 'expense'})
          Notification.success()
         })
         .catch(error =>this.errors = error.response.data.errors)
      },
     }
   
   
   }
</script>
<style type="text/css">
</style>