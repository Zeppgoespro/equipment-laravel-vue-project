<template>
    <div id="app">
        <h1>Система учёта оборудования</h1>
        <EquipmentList />
        <hr>
        <EquipmentTypeList />
    </div>
</template>

<script>
    import EquipmentList from './components/EquipmentList.vue';
    import EquipmentTypeList from './components/EquipmentTypeList.vue';

    export default {
        components: {
            EquipmentList,
            EquipmentTypeList
        },
    };
</script>

<style>
body {
  font-family: 'Roboto', sans-serif;
}

</style>
