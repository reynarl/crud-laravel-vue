<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    departaments: {type:Object}
})

const form = useForm({
    id:''
})

const deleteDepartmentModal = (department) => {
    const alert = Swal.mixin({
        buttonsStyling:true
    })
    alert.fire({
        title:'Estas seguro de eliminar este departamento?',
        icon:'question', showCancelButton:true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if(result.isConfirmed){
            form.delete(route('departaments.destroy', department))
        }
    })
}
</script>

<template>
    <Head title="Departments" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departments</h2>
        </template>

        <div class="py-12">
            <div class="grid bg-white v-screen place-items-center">
                <div class="bg-green-600 rounded-md px-2 py-2 mt-4 text-white">
                    <Link :href="route('departaments.create')" class="px-10">Add</Link>
                </div>
                <div>
                <table class="table-auto border border-gray-400 mt-4">
                    <thead>
                        <tr class="bg-gray-200">
                            <th>ID</th>
                            <th>DEPARTMENT</th>
                            <th colspan="2">OPTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="departament, index in departaments" :key="departament.id">
                            <td class="border border-gray-400 px-4 py-4">{{ index +1 }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ departament.name }}</td>
                            <td class="border border-gray-400 px-4 py-4"><Link :href="route('departaments.edit', departament)">Edit</Link></td>
                            <td class="border border-gray-400 px-4 py-4"><button @click="deleteDepartmentModal(departament)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>

        </div>
    </AuthenticatedLayout>

</template>
