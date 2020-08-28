<template>
    <div class="w-1/2">
        <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="selectedDoctor" @change="onChangeDoctor">
            <option>Choose a doctor</option>
            <option v-for="doctor in JSON.parse(doctors)" :key="doctor.id" :value="doctor.id">{{ doctor.name }}</option>
        </select>
    </div>
</template>

<script>
export default {
    props: [
        'doctors',
    ],
    data() {
        return {
            selectedDoctor: 'Choose a doctor',
        }
    },
    mounted() {
        console.log(this.doctors);
    },
    methods: {
        onChangeDoctor: function () {

        },
    }
}
</script>
