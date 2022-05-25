<template>
	<div>
		<div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">All Employee</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Employee</li>
              </ol>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  
                  <div >
                    <h6 class="d-inline m-0 font-weight-bold text-primary">Employee List</h6>
                    &nbsp;
                    <input type="text" v-model="searchTerm" name="" placeholder="Search">
                  </div>
                  
                  <router-link to=/store-employee class="btn btn-sms btn-primary">Add Employee</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Sallery</th>
                        <th>Joining Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="employee in filterSearch" :key="employee.id">
                        <td>{{ employee.name }}</td>
                        <td><img :src="employee.photo" id="em_photo" ></td>
                        <td>{{ employee.email }}</td>
                        <td>{{ employee.phone }}</td>
                        <td>{{ employee.sallery }}</td>
                        <td>{{ employee.joining_Date }}</td>
                        <td>
                          <router-link :to="{name: 'edit-employee', params:{id:employee.id}}" class="btn btn-sm btn-primary"><i class="far fa-fw fa-edit"></i></router-link>
                          <router-link :to="{name: 'view-employee', params:{id:employee.id}}" class="btn btn-sm btn-info"><i class="far fa-fw fa-eye"></i></router-link>
                          <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="color:white;"></i></a>
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
           employees:[],
           searchTerm:''
        } 
     },
     computed:{
      filterSearch(){
        return this.employees.filter(employee => {
          return employee.name.match(this.searchTerm)
        })
      }
     },
     methods:{
        allEmployee(){
          axios.get('/api/employee/')
          .then(({data}) => (this.employees = data))
          .catch()
         },
        deleteEmployee(id){
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
            axios.delete('/api/employee/'+id)
            .then(() => {
              this.employees = this.employees.filter(employee => {
                return employee.id != id
              })
            })
            .catch(() => {
              this.$router.push({name: 'employee'})
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
       this.allEmployee();
     }
   
   
   }
</script>
<style type="text/css">
	#em_photo{
    width: 40px; 
    height: 40px;
  }
</style>