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
                <div class="card">
                    <div class="card-header bg-white overflow-hidden shadow-m sm:rounded-lg">
                        <div class="row">
                            <div class="col-md-6">
                                  <h5 class="text-gray-900 float-start">Welcome To Agendas</h5>
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
                                    <th>Agenda #</th>
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
                                            <button @click="editAgenda(item)" class="btn btn-primary btn-sm">Edit</button>
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
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="agendaModalLabel">{{ !editStatus ? 'Adding Agenda' : 'Updating Agenda' }}</h5>
                        <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form class="form-group" action="./api/storeAgenda" method="post" @submit.prevent="storeAgendaAgenda()">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <input type="text" class="form-control"  v-model="taskData.title" required>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="message">Message:</label>
                                            <input type="text" class="form-control" v-model="taskData.message" required>
                                        </div>
                                </div>
                                <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="type">Type:</label>
                                            <input type="text" class="form-control" v-model="taskData.type" required>
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
                    </div> <!--end of modal body-->
                    <div class="modal-footer">
                        <button  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button @click="!editStatus ? storeAgenda() : updateAgenda()" class="btn btn-primary">{{ !editStatus ? 'Add' : 'Update' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    data(){
        return{
            editStatus: false,
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
            this.editStatus = false
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
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                $('#agendaModal').modal('hide')
            }
            )
        },
        editAgenda(item){
            this.editStatus = true
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
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                $('#agendaModal').modal('hide')
            }
            ) 
        }
    }
};
</script>