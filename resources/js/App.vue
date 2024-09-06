<template>
    <div id="app">
        <h1>Система учёта оборудования</h1>
        <EquipmentList />
    </div>
</template>

<script>
    import EquipmentList from './components/EquipmentList.vue';

    export default {
        components: {
            EquipmentList,
        },
    };
</script>

<style>
</style>
