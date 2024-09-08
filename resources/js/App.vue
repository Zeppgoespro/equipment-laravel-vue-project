<template>
    <div id="app" class="main-container">
        <h1>Система учёта оборудования Borozepp 4000</h1>
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
  color: rgb(27, 27, 27);
}

.main-container {
    max-width: 1360px;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.grand-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.error {
    color: red;
    margin: 5px 0;
    font-size: 0.9em;
}

.loading {
    color: blue;
    margin: 10px 0;
    font-size: 1em;
}

.success-msg-container {
    display: flex;
    justify-content: center;
    padding: 10px;
    margin: 0;
}

.success {
    color: green;
    margin: 6px 0;
    font-size: 1em;
    border: 2px solid rgb(27, 27, 27);
    border-radius: 6px;
    padding: 18px 14px;
}

/* EquipmentList.vue */
.el-search-container {
    padding: 19px;
    border: 2px solid rgb(27, 27, 27);
    border-radius: 10px;
    margin-bottom: 18px;
}
.el-search-container > div:first-of-type {
    margin-bottom: 18px;
    display: flex;
    gap: 16px;
}
.el-search-container > div:last-child {
    display: flex;
    justify-content: space-between;
    gap: 12px;
}
.el-search-container > div:last-child input {
    flex: 1;
}

.el-container {
    padding: 16px;
    border: 2px solid rgb(27, 27, 27);
    border-radius: 10px;
}
.el-container ul {
    padding-left: 0px;
}
.el-container li {
    padding: 8px;
    border: 1px solid black;
    border-radius: 6px;
    list-style: none;
    display: flex;
    justify-content: space-between;
    gap: 18px;
    transition: all .15s;
}
.el-container li:not(:last-of-type) {
    margin-bottom: 5px;
}
.el-container li:hover {
    background-color: rgb(182, 250, 255);
}

.el-create-container,
.el-edit-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    border: 2px solid rgb(27, 27, 27);
    border-radius: 10px;
    margin-top: 18px;
    margin-bottom: 18px;
    padding: 20px;
}
.el-create-container h3,
.el-edit-container h3 {
    margin-top: 4px;
}
.el-create-container .el-create-select,
.el-edit-container .el-edit-select {
    display: flex;
    gap: 8px;
}
.el-create-buttons,
.el-edit-buttons {
    display: flex;
    justify-content: center;
    gap: 12px;
}

/* EquipmentTypeList.vue */
.etl-search-container {
    display: flex;
    justify-content: space-between;
    width: 90%;
    gap: 8px;
    margin: 10px 0 22px 0;
}
.etl-search-container input {
    flex: 1;
}

.etl-container {
    padding: 19px;
    border: 2px solid rgb(27, 27, 27);
    border-radius: 10px;
    margin-bottom: 18px;
}
.etl-container ul {
    padding-left: 0px;
}
.etl-container li {
    padding: 8px;
    border: 1px solid black;
    border-radius: 6px;
    list-style: none;
    display: flex;
    justify-content: space-between;
    gap: 18px;
}
.etl-container li:not(:last-of-type) {
    margin-bottom: 5px;
}

</style>
