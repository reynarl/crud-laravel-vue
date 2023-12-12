<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend } from 'chart.js';

  ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

const props = defineProps({
    data: {type:Object}
})

const data = {
  labels: props?.data?.map(data => data.name),
  datasets: [
    {
      label: 'Employees',
      backgroundColor: '#f87975',
      data: props.data?.map(data => data.count)
    }
  ]
}

</script>

<template>
    <Head title="Graphic" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Graphic</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Line :data="data"></Line>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
