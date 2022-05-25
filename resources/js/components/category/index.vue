<template>
	<div>
		<div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">All Category</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Category</li>
              </ol>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  
                  <div >
                    <h6 class="d-inline m-0 font-weight-bold text-primary">Category List</h6>
                    &nbsp;
                    <input type="text" v-model="searchTerm" name="" placeholder="Search">
                  </div>
                  
                  <router-link to=/store-category class="btn btn-sms btn-primary">Add Category</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Category Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="category in filterSearch" :key="category.id">
                        <td>{{ category.category_name }}</td>
                        <td>
                          <router-link :to="{name: 'edit-category', params:{id:category.id}}" class="btn btn-sm btn-primary"><i class="far fa-fw fa-edit"></i></router-link>
                          <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="color:white;"></i></a>
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
           categories:[],
           searchTerm:''
        } 
     },
     computed:{
      filterSearch(){
        return this.categories.filter(category => {
          return category.category_name.match(this.searchTerm)
        })
      }
     },
     methods:{
        allCategory(){
          axios.get('/api/category/')
          .then(({data}) => (this.categories = data))
          .catch()
         },
        deleteCategory(id){
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
            axios.delete('/api/category/'+id)
            .then(() => {
              this.categories = this.categories.filter(category => {
                return category.id != id
              })
            })
            .catch(() => {
              this.$router.push({name: 'category'})
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
       this.allCategory();
     }
   
   
   }
</script>
<style type="text/css">
	#em_photo{
    width: 40px; 
    height: 40px;
  }
</style>