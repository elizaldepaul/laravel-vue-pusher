<template>
    <div>
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <div class="container">

            <h2>Student Registation</h2>
            <form @submit.prevent="save">

                <div class="form-group">
                    <label>Student name</label>
                    <input type="text" v-model="student.name" class="form-control" placeholder="Student name">

                </div>
                <div class="form-group">
                    <label>Student Address</label>
                    <input type="text" v-model="student.address" class="form-control" placeholder="Student Address">

                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" v-model="student.phone" class="form-control" placeholder="Phone">

                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>


            <h2>Employee View</h2>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="student in result" v-bind:key="student.id">

                        <td>{{ student.id }}</td>
                        <td>{{ student.name }}</td>
                        <td>{{ student.address }}</td>
                        <td>{{ student.phone }}</td>
                        <td>
                            <button type="button" class="btn btn-warning" @click="edit(student)">Edit</button>
                            <button type="button" class="btn btn-danger" @click="remove(student)">Delete</button>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div> -->

        <nav class="navbar navbar-dark bg-light">
            <a class="navbar-brand text-dark" href="#"><b>Laravel Vue</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            </button>
        </nav>


        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-black">Laravel Vue </h3>
                    <hr>
                    <button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal"
                        data-target="#addStudentModal" @click="clearFormData()">
                        <i class="fas fa-user-plus"></i> Add
                    </button>

                    <table class="table table-bordered">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th><i class="fas fa-user"></i> ID#</th>
                                <th><i class="fas fa-user"></i> Name</th>
                                <th><i class="fas fa-envelope"></i> Email</th>
                                <th><i class="fas fa-address-card"></i>Email Address</th>
                                <th> Age</th>
                                <th><i class="fas fa-cog"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in result" v-bind:key="user.id">
                                <td>{{ user.id }} </td>
                                <td>{{ user.first_name }} </td>
                                <td>{{ user.last_name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ calculateAge(user.birth_date) }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editStudentModal" @click="edit(user)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteStudentModal" @click="confirmDeletion(user)">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Student Modal -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="save">

                        <div class="modal-header">
                            <h5 class="modal-title" id="addStudentModalLabel"><i class="fas fa-user-plus"></i> Add
                                Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i>First Name</label>
                                <input type="text" v-model="user.first_name" class="form-control" required>

                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Last Name </label>
                                <input type="text" v-model="user.last_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="fas fa-address-card"></i> Email</label>
                                <input type="email" v-model="user.email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="fas fa-address-card"></i> Birth Date</label>
                                <input type="date" v-model="user.birth_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="fas fa-address-card"></i> Birth Date</label>
                                <input type="password" v-model="user.password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <select v-model="user.role" id="role" class="form-control" required>
                                    <option value="">Choose Your Role</option>
                                    <option value="1">1 as User</option>
                                    <option value="2">2 as Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Student Modal (for each student) -->

        <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog"
            aria-labelledby="editStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="save">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editStudentModalLabel"><i class="fas fa-user-plus"></i> Add
                                Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i>First Name</label>
                                <input type="text" v-model="user.first_name" class="form-control" required>

                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Last Name </label>
                                <input type="text" v-model="user.last_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="fas fa-address-card"></i> Email</label>
                                <input type="email" v-model="user.email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="fas fa-address-card"></i> Birth Date</label>
                                <input type="date" v-model="user.birth_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="fas fa-address-card"></i> Password</label>
                                <input type="password" v-model="user.password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <select v-model="user.role" id="role" class="form-control" required>
                                    <option value="">Choose Your Role</option>
                                    <option value="1">1 as User</option>
                                    <option value="2">2 as Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteStudentModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteStudentModalLabel"><i class="fas fa-user-plus"></i> Are
                            you sure you want to delete this user?
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">
                                {{ user.first_name }}
                            </label>
                            <input type="hidden" name="id" value="" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" @click="remove(user)"><i
                                class="ri-delete-bin-2-fill"></i>
                            Delete</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import axios from 'axios';
import Pusher from 'pusher-js';

// Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;


export default {
    name: 'User',
    data() {
        return {
            result: {},
            user: {
                id: '',
                role: '',
                password: '',
                first_name: '',
                last_name: '',
                email: '',
                birth_date: '',
            },
            messages: []
        }
    },
    created() {
        this.UserLoad();
        const pusher = new Pusher('5c1761274aadc8cb76d9', {
            cluster: 'ap1',
            encrypted: true
        });

        pusher.connection.bind('connected', () => {
            console.log('Pusher connected!');
        });

        const channel = pusher.subscribe('laravel-vue-pusher');

        channel.bind('save-event', data => {
            toastr.success('User saved successfully');
            this.clearFormData();
            $('#addStudentModal').modal('hide');
            this.UserLoad();
        });

        channel.bind('update-event', data => {
            toastr.success('User updated successfully');
            $('#editStudentModal').modal('hide');
            this.UserLoad();
        });

        channel.bind('remove-event', data => {
            toastr.success('User deleted successfully');
            $('#deleteStudentModal').modal('hide');
            this.UserLoad();
        });

    },
    methods: {
        UserLoad() {
            var page = "http://127.0.0.1:8000/api/user";
            axios.get(page)
                .then(
                    ({ data }) => {
                        this.result = data;
                    }
                );
        },
        calculateAge(birth_date) {
            if (!birth_date) return ''; // If birth date is not set, return empty string
            const today = new Date();
            const birthDate = new Date(birth_date);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            // If the current month is less than the birth month or if it's the same month but the current day is less than the birth day, subtract 1 from age
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        },
        save() {
            if (this.user.id == '') {
                this.saveData();
            }
            else {
                this.updateData();
            }
        },
        saveData() {
            // console.log(this.user);
            axios.post("http://127.0.0.1:8000/api/user", this.user)
                .then(({ data }) => {
                })
                .catch(error => {
                    console.error("Error saving user:", error);
                    toastr.error('Error saving user');
                });
        },
        clearFormData() {
            this.user.first_name = '';
            this.user.last_name = '';
            this.user.email = '';
            this.user.birth_date = '';
            this.user.password = '';
            this.user.id = '';
        },
        edit(user) {
            this.user = {
                id: user.id,
                first_name: user.first_name,
                last_name: user.last_name,
                email: user.email,
                birth_date: user.birth_date,
                password: user.password,
                role: user.role
            }
        },

        updateData() {
            var editrecords = 'http://127.0.0.1:8000/api/user/' + this.user.id;
            axios.put(editrecords, this.user)
                .then(
                    ({ data }) => {
                    this.clearFormData();
                    }
                );
        },
        confirmDeletion(user) {
            this.user = user;

        },
        remove(user) {
            var url = `http://127.0.0.1:8000/api/user/${user.id}`;
            axios.delete(url)
                .then(
                    ({ data }) => {
                    this.clearFormData();
                    }
                )
                .catch(error => {
                    console.error('Error deleting user:', error);
                    // Handle error, show error message, etc.
                });
        }
    }
}
</script>