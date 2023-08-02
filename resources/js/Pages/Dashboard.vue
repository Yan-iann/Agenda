<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
</script>

<template>
    <Head>
        <title>Home Page</title>    
    </Head>

    <AuthenticatedLayout>
       <div class="row justify-content-center mx-auto">
            <div class="col-md-8 py-4">
                <div id="alert" class="alert alert-warning alert-dismissable fade show" v-show="crudStatus != '' && !deleteStatus && !deleteDB">{{ crudStatus }}</div>
                 <div class="alert alert-warning alert-dismissable fade show" v-show="crudStatus != '' && deleteStatus && deleteDB">{{ crudStatus }}</div>
                <div class="card">
                    <div class="card-header bg-white overflow-hidden shadow-m sm:rounded-lg">
                        <div class="row">
                            <div class="col-md-6">
                                  <h5 class="text-4xl text-gray-900 float-start font-bold">Agendas</h5>
                            </div>
                            <div class="col-md-6">
                                <button @click="createAgenda" class="btn btn-success btn-m float-right">Add Agenda</button>
                            </div>
                        </div>  
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>Agenda No.</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Type</th>
                                    <th>Author</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in agenda" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ item.title }}</td>
                                        <td>{{ item.message.length <=20 ? item.message : item.message.subtr(0,20) + '...' }}</td>
                                        <td>{{ item.type }}</td>
                                        <td>{{ item.author }}</td>
                                        <td>
                                            <button @click="editAgenda(item)" class="btn btn-primary btn-sm mx-2">Edit</button>
                                            <button @click="deleteAgenda(item)" class="btn btn-danger btn-sm mx-2">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!--end of card-->
            </div> 
       </div>
    
       <!--Modal for adding-->
        <div class="modal fade" id="agendaModal" tabindex="-1" aria-labelledby="agendaModalLabel" aria-hidden="true">
            <div :class="`modal-dialog modal-dialog-centered ${!deleteStatus ? 'modal-md' : 'modal-sm'}`">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="agendaModalLabel" v-show="!deleteStatus">{{ !editStatus ? 'Adding Agenda' : 'Updating Agenda' }}</h5>
                        <h5 class="modal-title fs-5" id="agendaModalLabel" v-show="deleteStatus">Delete Agenda</h5>
                        <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" v-show="!deleteStatus">
                            <div class="col-12 col-lg-12">
                                <form class="form-group" action="./api/storeAgenda" method="post" @submit.prevent="storeAgendaAgenda()">
                                
                                    <div class="col-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="title">Title:</label>
                                            <input type="text" class="form-control"  v-model="taskData.title" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="message">Message:</label>
                                                <input type="text" class="form-control" v-model="taskData.message" required>
                                            </div>
                                    </div>
                                <div class="col-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="type">Type: </label>
                                             <select class="select floating col-12 col-lg-12" name="type" v-model="taskData.type">
                                                <option value="News">News</option>
                                                <option value="Update">Update</option>
                                                <option value="Task">Task</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="author">Author:</label>
                                            <input type="text" class="form-control" v-model="taskData.author" required>
                                        </div>
                                </div>
                                </form>  
                            </div>
                        </div>

                        <!--Show if delete is performed-->
                         <h5 class="text-center" v-show="deleteStatus">Are you sure you want to delete this agenda?</h5>
                         
                    </div> <!--end of modal body-->

                      <!--Show if delete button is not clicked-->
                    <div class="modal-footer" v-show="!deleteStatus">
                        <button  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button @click="!editStatus ? storeAgenda() : updateAgenda()" class="btn btn-primary">{{ !editStatus ? 'Add' : 'Update' }}</button>
                    </div>

                    <!--Show if delete button is clicked-->
                    <div class="modal-footer" v-show="deleteStatus">
                            <button  class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button @click="removeAgenda()" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<!--All methods used-->
<script>

export default {
    
    data(){
        return{
            editStatus: false,
            deleteStatus: false,
            deleteDB: false,
            crudStatus: '',
            taskData:{
                id:'',
                title:'',
                message: '',
                type: '',
                author: '',
            },
            agenda: {},
        }
    },
    mounted(){
        this.getAgenda()
    },
    methods: {
        getAgenda(){
            axios.get('./api/getAgenda').then(response => {
                this.agenda = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        createAgenda(){
            
            this.deleteStatus = false
            this.editStatus = false
            this.deleteDB = false
            this.taskData = {
                id: '',
                title: '',
                message: '',
                type: '',
                author: '', 
            }
            $('#agendaModal').modal('show')
        },
        storeAgenda(){
            axios.post('./api/storeAgenda', this.taskData).then(response => {
                this.getAgenda()
                this.crudStatus = 'Agenda Successfully Created'
            }).catch(error => {
                 this.crudStatus = 'Please fill up all the inputs'
            }).finally(() => {
                $('#agendaModal').modal('hide')
                
            }
            )
        },
        editAgenda(item){
            this.editStatus = true
            this.deleteStatus = false
            this.deleteDB = false
            this.taskData = {
                id: item.id,
                title: item.title,
                message: item.message,
                type: item.type,
                author: item.author,
            }
            $('#agendaModal').modal('show')
        },
        updateAgenda(item){
           axios.post('./api/updateAgenda/' + this.taskData.id, this.taskData).then(response => {
                this.getAgenda()
                this.crudStatus = 'Agenda Successfully Updated'
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                $('#agendaModal').modal('hide')
            }
            ) 
        },
        deleteAgenda(item){
            this.deleteStatus = true
            this.taskData.id = item.id
            $('#agendaModal').modal('show')
        },
        removeAgenda(item){
            axios.post('./api/removeAgenda/' + this.taskData.id).then(response => {
                this.getAgenda()
                this.crudStatus = 'Agenda Successfully Deleted'
                this.deleteDB = true
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                $('#agendaModal').modal('hide')
            }
            )
        },
    }
};
</script>