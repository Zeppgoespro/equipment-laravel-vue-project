<template>
    <div>
        <h2>Список типов оборудования</h2>

        <!-- Поиск по названию -->
        <input v-model="searchQuery" placeholder="Введите название типа оборудования..." />
        <button @click="fetchEquipmentTypes">Найти</button>

        <!-- Список типов оборудования -->
        <ul>
            <li v-for="type in equipmentTypes" :key="type.id">
                {{ type.name }} - Маска: {{ type.mask }}
            </li>
        </ul>

        <!-- Управление пагинацией -->
        <div v-if="pagination.total > pagination.perPage">
            <button @click="fetchEquipmentTypes(pagination.currentPage - 1)" :disabled="pagination.currentPage === 1">
                Назад
            </button>
            <button @click="fetchEquipmentTypes(pagination.currentPage + 1)" :disabled="pagination.currentPage === pagination.totalPages">
                Вперед
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            searchQuery: '',
            equipmentTypes: [],
            pagination: {
                currentPage: 1,
                total: 0,
                perPage: 10,
                totalPages: 0
            }
        };
    },
    methods: {
        /**
         * Получает список типов оборудования с возможностью поиска и пагинации.
         *
         * @param {number} page Номер страницы.
         */
        fetchEquipmentTypes(page = 1) {
            const params = {
                page: page,
                name: this.searchQuery
            };

            axios
                .get('/api/equipment-type', { params })
                .then((response) => {
                    this.equipmentTypes = response.data.data;
                    this.pagination.currentPage = response.data.meta.current_page;
                    this.pagination.total = response.data.meta.total;
                    this.pagination.perPage = response.data.meta.per_page;
                    this.pagination.totalPages = response.data.meta.last_page;
                })
                .catch((error) => {
                    console.error('Ошибка при получении типов оборудования:', error);
                });
        }
    },
    mounted() {
        this.fetchEquipmentTypes();  // Получить начальный список при загрузке компонента
    }
};
</script>

<style scoped>
</style>
