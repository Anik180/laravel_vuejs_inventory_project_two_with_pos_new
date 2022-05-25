<template>
	<div>
		<div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">Salary</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Salary</li>
              </ol>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  
                  <div >
                    <h6 class="d-inline m-0 font-weight-bold text-primary">Employee Salary Information</h6>
                    &nbsp;
                    <input type="text" v-model="searchTerm" name="" placeholder="Search">
                  </div>
                  
                  <router-link to=/salary class="btn btn-sms btn-primary">Go Back</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="salary in filterSearch" :key="salary.id">
                        <td>{{ salary.name }}</td>
                        <td>{{ salary.month }}</td>
                        <td>{{ salary.amount }}</td>
                        <td>{{ salary.date }}</td>
                        <td>
                          <router-link :to="{name: 'edit-salary', params:{id:salary.id}}" class="btn btn-sm btn-primary"><i class="fa fa-edit" aria-hidden="true"></i></router-link>
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
           salaries:[],
           searchTerm:''
        } 
     },
     computed:{
      filterSearch(){
        return this.salaries.filter(salary => {
          return salary.name.match(this.searchTerm)
        })
      }
     },
     methods:{
        viewSalary(){
         let id = this.$route.params.id
         axios.get('/api/salary/view/'+id)
         .then(({data}) =>(this.salaries = data))
         .catch(error =>this.errors = error.response.data.errors)
         }
     },
     created(){
       this.viewSalary();
     }
   
   
   }
</script>
<style type="text/css">
	#em_photo{
    width: 40px; 
    height: 40px;
  }
</style>