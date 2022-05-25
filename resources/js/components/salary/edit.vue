<template>
   <div>
      <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pay Salary</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Update Salary</li>
            </ol>
         </div>
         <div class="row">
            <div class="">
               <!-- Form Basic -->
               <div class="card mb-4 ">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Update Salary</h6>
                     <router-link to=/given-salary class="btn btn-sms btn-primary">Salary</router-link>
                  </div>
                  <div class="card-body">
                     <form class="user" @submit.prevent="updateSalary">
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label for="exampleInputEmail1">Employee Name</label>
                                 <input type="text" class="form-control" placeholder="Enter Employee Name" v-model="form.name">
                                 <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }}</small>
                              </div>
                              <div class="col">
                                 <label for="exampleInputEmail1">Email</label>
                                 <input type="email" class="form-control" placeholder="Enter Email" v-model="form.email">
                                 <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                            <input type="hidden" v-model="form.employee_id">
                              <div class="col">
                                 <label for="exampleInputPassword1">Amount</label>
                                 <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Enter Amount" v-model="form.amount">
                                 <small class="text-danger" v-if="errors.amount"> {{ errors.amount[0] }}</small>
                              </div>
                              <div class="col">
                                    <label for="exampleFormControlSelect1">Month</label>
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.month" >
                                       <option value="January">January</option>
                                       <option value="February">February</option>
                                       <option value="March">March</option>
                                       <option value="April">April</option>
                                       <option value="May">May</option>
                                       <option value="June">June</option>
                                       <option value="July">July</option>
                                       <option value="August">August</option>
                                       <option value="September">September</option>
                                       <option value="October">October</option>
                                       <option value="November">November</option>
                                       <option value="December">December</option>
                                    </select>
                                     <small class="text-danger" v-if="errors.month"> {{ errors.month[0] }}</small>
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
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
              name: '',
              email: '',
              month: '',
              amount: '',
              employee_id: ''
           },
           errors:{}
        } 
     },
     created(){
      let id = this.$route.params.id
      axios.get('/api/salary/edit/' +id)
      .then(({data}) =>(this.form = data))
      .catch(console.log('error'))
     },
     methods:{
      updateSalary(){
         let id = this.$route.params.id
         axios.post('/api/salary/update/'+id,this.form)
         .then(() => {
          this.$router.push({ name: 'salary'})
          Notification.success()
         })
         .catch(error =>this.errors = error.response.data.errors)
      }
     }
   
   
   }
</script>
<style type="text/css">
</style>