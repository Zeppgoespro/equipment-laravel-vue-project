<template>
    <div class="grand-container">
        <h2>СПИСОК ТИПОВ ОБОРУДОВАНИЯ</h2>

        <!-- Поиск по названию -->
        <div class="etl-search-container">
            <input v-model="searchQuery" placeholder="Введите название типа оборудования..." />
            <button @click="fetchEquipmentTypes">Найти</button>
        </div>

        <!-- Индикатор загрузки для списка типов оборудования -->
        <div class="etl-container">
            <div v-if="loading" class="loading">Загрузка...</div>

            <!-- Список типов оборудования -->
            <ul v-else>
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
            },
            loading: false  // Состояние индикатора загрузки
        };
    },
    methods: {
        /**
         * Получает список типов оборудования с возможностью поиска и пагинации.
         *
         * @param {number} page Номер страницы.
         */
        fetchEquipmentTypes(page = 1) {
            this.loading = true;  // Начинаем индикатор загрузки
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
                })
                .finally(() => {
                    this.loading = false;  // Останавливаем индикатор загрузки
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
