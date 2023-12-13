<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import pdfmake from 'pdfmake/build/pdfmake';
// import pdfFonts from "pdfmake/build/vfs_fonts";
import SelectInput from '@/Components/SelectInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import DataTable from 'datatables.net-vue3';
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5'
import JsZip from 'jszip'

import 'datatables.net-dt/css/jquery.dataTables.css'
import 'datatables.net-buttons/js/buttons.print'
import 'datatables.net-responsive-dt'
import 'datatables.net-responsive-dt/css/responsive.dataTables.min.css'

import { ref } from 'vue'

import * as pdfFonts from 'pdfmake/build/vfs_fonts'

// pdfmake.vfs = pdfFonts.pdfMake.vfs;
pdfmake.vfs = pdfFonts.pdfMake ? pdfFonts.pdfMake.vfs : pdfmake.vfs
window.JSZip = JsZip

DataTable.use(ButtonsHtml5)

const props = defineProps({
    employees: {type:Object},
    departaments: {type:Object}
})



const columns1 = ref([])
const columns2 = ref([])
const buttons1 = ref([])
const buttons2 = ref([])
const report = ref('1')

const optionsSelect = ref([
    {'id': '1', 'name':'Employees'},
    {'id': '2', 'name':'Departments'}
])

columns1.value = [
    {
        data:null, render:function(data,type,row,meta)
        {return(meta.row + 1)}
    },
    {data: 'name'},
    {data: 'email'},
    {data: 'phone'},
    {data: 'departament'}
]

columns2.value = [
    {
        data:null, render:function(data,type,row,meta)
        {return(meta.row + 1)}
    },
    {data: 'name'}
]

buttons1.value = [
    {
        title: 'Employees', extend: 'excelHtml5',
        text: '<i class="fa-solid fa-file-excel"></i> Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white hove:bg-green-700'
    },
    {
        title: 'Employees', extend: 'pdfHtml5',
        text: '<i class="fa-solid fa-file-pdf"></i> PDF',
        className:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
    },
    {
        title: 'Employees', extend: 'copyHtml5',
        text: '<i class="fa-solid fa-file-copy"></i> COPY',
        className:"inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
    }
]

buttons2.value = [
    {
        title: 'Departments', extend: 'excelHtml5',
        text: '<i class="fa-solid fa-file-excel"></i> Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white hove:bg-green-700'
    },
    {
        title: 'Departments', extend: 'pdfHtml5',
        text: '<i class="fa-solid fa-file-pdf"></i> PDF',
        className:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
    },
    {
        title: 'Departments', extend: 'copyHtml5',
        text: '<i class="fa-solid fa-file-copy"></i> COPY',
        className:"inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
    }
]

</script>

<template>
    <Head title="Reports" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <InputLabel for="report" value="Reports:" />
                        <SelectInput id="report" :options="optionsSelect" v-model="report" class="" />
                    </div>
                    <div v-if="report === '1'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                        <DataTable
                            :data="employees"
                            :columns="columns1"
                            class="w-full border border-gray-400"
                            :options="{responsive:true, autoWidth:false, dom:'Bfrtip', buttons:buttons1}"
                        >
                            <thead>
                                <tr>
                                    <th class="px-2 py-2">#</th>
                                    <th class="px-2 py-2">NAME</th>
                                    <th class="px-2 py-2">EMAIL</th>
                                    <th class="px-2 py-2">PHONE</th>
                                    <th class="px-2 py-2">DEPARTMENT</th>
                                </tr>
                            </thead>
                        </DataTable>
                    </div>
                    <div v-else="report === '2'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable
                        :data="departaments"
                        :columns="columns2"
                        class="w-full border border-gray-400"
                        :options="{responsive:true, autoWidth:false, dom:'Bfrtip', buttons:buttons2}"
                    >
                        <thead>
                            <tr>
                                <th class="px-2 py-2">#</th>
                                <th class="px-2 py-2">NAME</th>
                            </tr>
                        </thead>
                    </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
