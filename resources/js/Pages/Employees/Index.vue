<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import Modal from '@/Components/Modal.vue';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref, nextTick } from 'vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    employees : {type:Object},
    departaments: {type:Object}
})

const nameInput = ref(null)
const modal = ref(false)
const title = ref('')
const operation = ref(1)
const id = ref('')

const form = useForm({
    name:'', email:'', phone:'', departament_id:''
})


const formPage = useForm({})

const onPageClick = e => {
    formPage.get(route('employees.index',{page:e}))
}

const openModal = (op, name,email,phone,departament,employee) => {
    modal.value = true
    nextTick(() => nameInput.value.focus)
    operation.value = op
    id.value = employee
    if(op === 1){
        title.value = 'Create employee'
    }else {
        title.value = 'Edit Employee'
        form.name = name
        form.email = email
        form.phone = phone
        form.departament_id = departament

    }
}

const closeModal = () => {
    modal.value = false
    form.reset()
}

const ok = (msg) => {
    form.reset()
    closeModal()
    Swal.fire({title:msg, icon:'success'})
}

const save = () => {
    if(operation.value === 1){
        form.post(route('employees.store'), {
            onSuccess: () => ok('Employee created')
        })
    } else {
        form.put(route('employees.update', id, value), {
            onSuccess: () => ok('Employee updated')
        })
    }
}

const deleteEmployeeModal = (employee) => {
    const alert = Swal.mixin({
        buttonsStyling:true
    })
    alert.fire({
        title:`Estas seguro de eliminar el empleado: ${employee.name} ?`,
        icon:'question', showCancelButton:true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if(result.isConfirmed){
            form.delete(route('employees.destroy', employee),{
                onSuccess: () => ok('Empleado eliminado')
            })
        }
    })
}
</script>

<template>
    <Head title="Departments" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <PrimaryButton @click="$e => openModal(1)">Add</PrimaryButton>
                        <table class="table-auto border border-gray-400 mt-4">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th>ID</th>
                                    <th>DEPARTMENT</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>PHONE</th>
                                    <th colspan="2">OPTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="employee in employees.data" :key="employee.id">
                                    <td class="border border-gray-400 px-4 py-4">{{ employee.id }}</td>
                                    <td class="border border-gray-400 px-4 py-4">{{ employee.departament }}</td>
                                    <td class="border border-gray-400 px-4 py-4">{{ employee.name }}</td>
                                    <td class="border border-gray-400 px-4 py-4">{{ employee.email }}</td>
                                    <td class="border border-gray-400 px-4 py-4">{{ employee.phone }}</td>
                                    <td class="border border-gray-400 px-4 py-4">
                                        <button class="bg-red-700 rounded-lg text-white px-2" @click="deleteEmployeeModal(employee)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <vueTailwindPaginationUmd
                            :current="employees.currentPage"
                            :total="employees.total"
                            :per-page="employees.perPage"
                            @page-changed="$e=>onPageClick($e)">
                        </vueTailwindPaginationUmd>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="text-lg p-3">{{ title }}</h2>
            <div class="w-96 m-auto">
                <div class="p-3">
                <InputLabel for="name" value="Name:" />
                <TextInput class="w-96" id="name" ref="nameInput" v-model="form.name" type="text" placeholder="Name"/>
                <InputError :message="form.errors.name" />
                </div>
                <div class="p-3">
                    <InputLabel for="phone" value="Phone:" />
                    <TextInput class="w-96" id="phone" v-model="form.phone" type="text" placeholder="Phone"/>
                    <InputError :message="form.errors.phone" />
                </div>
                <div class="p-3">
                    <InputLabel for="email" value="Email:" />
                    <TextInput class="w-96" id="email" v-model="form.email" type="text" placeholder="Email"/>
                    <InputError :message="form.errors.email" />
                </div>
                <div class="p-3">
                    <InputLabel for="demartament_id" value="Departments:" />
                    <SelectInput class="w-96" id="departament_id" v-model="form.departament_id" :options="departaments"></SelectInput>
                    <InputError :message="form.errors.demartament_id" />
                </div>
            </div>
            <div class="w-60 mt-3 p-3 flex justify-between m-auto">
                <PrimaryButton :disabled="form.processing" @click="save">
                    Save
                </PrimaryButton>
                <button :disabled="form.processing" @click="closeModal" class="rounded-md bg-pink-50 px-2 py-1 font-medium text-pink-700 ring-1 ring-inset ring-pink-700/10">Cancel</button>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
