<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    departament: {type: Object}
})

const form = useForm({
    name: props.departament.name
})
</script>

<template>
    <Head title="Edit" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="" @submit.prevent="$event => form.patch(route('departaments.update', departament))" class="flex flex-col w-96">
                            <InputLabel for="name" value="Department" />
                            <TextInput id="name" v-model="form.name" type="text" required/>
                            <InputError class="mt-2" :message="form.errors.name"></InputError>
                            <PrimaryButton class="px-10 m-auto mt-4">Update</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
