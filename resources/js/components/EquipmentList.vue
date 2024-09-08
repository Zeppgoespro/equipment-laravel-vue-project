<template>
    <div class="grand-container">
        <h2>СПИСОК ОБОРУДОВАНИЯ</h2>

        <!-- Выбор типа поиска -->
        <div class="el-search-container">
            <h3 style="text-align: center; margin-top: 0;">Поиск оборудования</h3>
            <div>
                <label>
                    <input type="radio" v-model="searchType" value="serial_number" checked> По серийному номеру
                </label>
                <label>
                    <input type="radio" v-model="searchType" value="desc"> По описанию
                </label>
            </div>
            <div>
                <input v-model="searchQuery" placeholder="Введите ваш запрос..." />
                <button @click="fetchEquipment">Найти</button>
            </div>
        </div>

        <div class="el-container">
            <!-- Индикатор загрузки для списка оборудования -->
            <div v-if="loading" class="loading">Загрузка...</div>

            <ul v-else>
                <li v-for="equipment in equipmentList" :key="equipment.id">
                    {{ equipment.serial_number }} - {{ equipment.desc }}
                    <div>
                        <button @click="editEquipment(equipment)">Изменить</button>
                        <button @click="deleteEquipment(equipment.id)">Удалить</button>
                    </div>
                </li>
            </ul>

            <!-- Управление пагинацией -->
            <div v-if="pagination.total > pagination.perPage">
                <button @click="fetchEquipment(pagination.currentPage - 1)" :disabled="pagination.currentPage === 1">
                    Назад
                </button>
                <button @click="fetchEquipment(pagination.currentPage + 1)" :disabled="pagination.currentPage === pagination.totalPages">
                    Вперед
                </button>
            </div>
        </div>

        <!-- Форма редактирования оборудования -->
        <div v-if="selectedEquipment && equipmentTypes.length > 0" class="el-edit-container">
            <h3>Редактировать оборудование</h3>

            <!-- Выбор типа оборудования -->
            <div>
                <div class="el-edit-select">
                    <span>Тип оборудования:</span>
                    <select v-model="selectedEquipment.equipment_type_id">
                        <option v-for="type in equipmentTypes" :key="type.id" :value="type.id">
                            {{ type.name }}
                        </option>
                    </select>
                </div>
                <div v-if="errors.selectedEquipment.equipment_type_id" class="error">{{ errors.selectedEquipment.equipment_type_id }}</div>
            </div>

            <input v-model="selectedEquipment.serial_number" placeholder="Серийный номер" />
            <button @click="generateSerialNumber('selected')">Сгенерировать серийный номер</button>
            <div v-if="errors.selectedEquipment.serial_number" class="error">{{ errors.selectedEquipment.serial_number }}</div>

            <input v-model="selectedEquipment.desc" placeholder="Описание" />

            <div class="el-edit-buttons">
                <button @click="updateEquipment">Сохранить</button>
                <button @click="cancelEdit">Отменить</button>
            </div>

            <!-- Индикатор загрузки для формы редактирования -->
            <div v-if="updating" class="loading">Сохранение...</div>
        </div>

        <div class="success-msg-container">
            <div v-if="successMessage" class="success">{{ successMessage }}</div> <!-- Отображение сообщения об успехе -->
        </div>

        <!-- Форма добавления нового оборудования -->
        <div class="el-create-container">
            <h3>Добавить новое оборудование</h3>

            <div>
                <div class="el-create-select">
                    <span>Тип оборудования:</span>
                    <select v-model="newEquipment.equipment_type_id">
                        <option v-for="type in equipmentTypes" :key="type.id" :value="type.id">
                            {{ type.name }}
                        </option>
                    </select>
                </div>
                <div v-if="errors.newEquipment.equipment_type_id" class="error">{{ errors.newEquipment.equipment_type_id }}</div>
            </div>

            <input v-model="newEquipment.serial_number" placeholder="Серийный номер" />
            <button @click="generateSerialNumber('new')">Сгенерировать серийный номер</button>
            <div v-if="errors.newEquipment.serial_number" class="error">{{ errors.newEquipment.serial_number }}</div>

            <input v-model="newEquipment.desc" placeholder="Описание" />
            <div v-if="errors.newEquipment.desc" class="error">{{ errors.newEquipment.desc }}</div>

            <div class="el-create-buttons">
                <button @click="createEquipment">Добавить</button>
                <button @click="resetCreationForm">Отменить</button> <!-- Новая кнопка "Отменить" для формы создания -->
            </div>

            <!-- Индикатор загрузки для формы создания -->
            <div v-if="creating" class="loading">Создание...</div>

            <!-- Сообщение об ошибке с бэкенда -->
            <div v-if="errors.newEquipment[0]" class="error">{{ errors.newEquipment[0] }}</div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            searchQuery: '',
            searchType: 'serial_number',
            equipmentList: [],
            selectedEquipment: null,
            equipmentTypes: [],
            newEquipment: {
                equipment_type_id: '',
                serial_number: '',
                desc: ''
            },
            errors: {
                newEquipment: {
                    equipment_type_id: '',
                    serial_number: ''
                },
                selectedEquipment: {
                    equipment_type_id: '',
                    serial_number: ''
                }
            },
            loading: false,  // Состояние индикатора загрузки
            creating: false,  // Состояние индикатора загрузки для создания
            updating: false,  // Состояние индикатора загрузки для обновления
            successMessage: '',  // Состояние сообщения об успехе
            pagination: {  // Состояние пагинации
                currentPage: 1,
                total: 0,
                perPage: 10,
                totalPages: 0
            }
        };
    },
    methods: {
        /**
         * Получает список оборудования с возможностью поиска и пагинации.
         *
         * @param {number} page Номер страницы.
         */
        fetchEquipment(page = 1) {
            this.loading = true;  // Включить индикатор загрузки
            const searchParams = {
                page: page,
                [this.searchType]: this.searchQuery.trim()
            };

            axios
                .get('/api/equipment', { params: searchParams })
                .then((response) => {
                    this.equipmentList = response.data.data;
                    this.pagination.currentPage = response.data.meta.current_page;
                    this.pagination.total = response.data.meta.total;
                    this.pagination.perPage = response.data.meta.per_page;
                    this.pagination.totalPages = response.data.meta.last_page;
                })
                .catch((error) => {
                    console.error('Ошибка при получении списка оборудования:', error);
                })
                .finally(() => {
                    this.loading = false;  // Отключить индикатор загрузки
                });
        },
        fetchEquipmentTypes() {
            axios
                .get('/api/equipment-type')
                .then((response) => {
                    this.equipmentTypes = response.data.data;
                })
                .catch((error) => {
                    console.error('Ошибка при получении типов оборудования:', error);
                });
        },
        editEquipment(equipment) {
            if (this.equipmentTypes.length === 0) {
                this.fetchEquipmentTypes().then(() => {
                    this.selectedEquipment = { ...equipment };
                });
            } else {
                this.selectedEquipment = { ...equipment };
            }
        },
        updateEquipment() {
            this.errors.selectedEquipment = { equipment_type_id: '', serial_number: '' };
            this.updating = true;  // Включить индикатор обновления
            this.successMessage = '';  // Очистить предыдущее сообщение об успехе

            if (!this.selectedEquipment.equipment_type_id) {
                this.errors.selectedEquipment.equipment_type_id = "Тип оборудования обязателен.";
                this.updating = false;  // Отключить индикатор обновления
                return;
            }

            if (!this.validateSerialNumber('selected')) {
                this.errors.selectedEquipment.serial_number = "Серийный номер не соответствует маске.";
                this.updating = false;  // Отключить индикатор обновления
                return;
            }

            axios
                .put(`/api/equipment/${this.selectedEquipment.id}`, this.selectedEquipment)
                .then(() => {
                    this.fetchEquipment();
                    this.selectedEquipment = null;
                    this.successMessage = "Оборудование успешно обновлено!";  // Показать сообщение об успехе
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        this.errors.selectedEquipment = error.response.data.errors.reduce((acc, curr) => {
                            acc[curr.index] = curr.message;
                            return acc;
                        }, {});
                    } else {
                        console.error('Ошибка при обновлении оборудования:', error);
                    }
                })
                .finally(() => {
                    this.updating = false;  // Отключить индикатор обновления
                });
        },
        deleteEquipment(id) {
            axios
                .delete(`/api/equipment/${id}`)
                .then(() => {
                    this.fetchEquipment();
                })
                .catch((error) => {
                    console.error('Ошибка при удалении оборудования:', error);
                });
        },
        createEquipment() {
            this.errors.newEquipment = { equipment_type_id: '', serial_number: '' };
            this.creating = true;  // Включить индикатор создания
            this.successMessage = '';  // Очистить предыдущее сообщение об успехе

            if (!this.newEquipment.equipment_type_id) {
                this.errors.newEquipment.equipment_type_id = "Тип оборудования обязателен.";
                this.creating = false;  // Отключить индикатор создания
                return;
            }

            if (!this.validateSerialNumber('new')) {
                this.errors.newEquipment.serial_number = "Серийный номер не соответствует маске.";
                this.creating = false;  // Отключить индикатор создания
                return;
            }

            axios
                .post('/api/equipment', this.newEquipment)
                .then(() => {
                    this.fetchEquipment();
                    this.newEquipment = { equipment_type_id: '', serial_number: '', desc: '' };  // Сброс формы после создания
                    this.successMessage = "Оборудование успешно добавлено!";  // Показать сообщение об успехе
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        this.errors.newEquipment = error.response.data.errors.reduce((acc, curr) => {
                            acc[curr.index] = curr.message;
                            return acc;
                        }, {});
                    } else {
                        console.error('Ошибка при создании оборудования:', error);
                    }
                })
                .finally(() => {
                    this.creating = false;  // Отключить индикатор создания
                });
        },
        validateSerialNumber(form) {
            const equipmentType = this.equipmentTypes.find(type => type.id === this[form + 'Equipment'].equipment_type_id);
            if (!equipmentType) return false;

            const mask = equipmentType.mask;
            let regexPattern = '^';

            for (const char of mask) {
                switch (char) {
                    case 'N':
                        regexPattern += '\\d';           // Цифра от 0 до 9
                        break;
                    case 'A':
                        regexPattern += '[A-Z]';         // Заглавная буква A-Z
                        break;
                    case 'a':
                        regexPattern += '[a-z]';         // Строчная буква a-z
                        break;
                    case 'X':
                        regexPattern += '[A-Z0-9]';      // Заглавная буква или цифра
                        break;
                    case 'Z':
                        regexPattern += '[-_@]';         // Специальные символы "-", "_", "@"
                        break;
                    default:
                        regexPattern += char;
                        break;
                }
            }

            regexPattern += '$';

            const pattern = new RegExp(regexPattern);
            return pattern.test(this[form + 'Equipment'].serial_number);
        },
        generateSerialNumber(form) {
            const equipmentType = this.equipmentTypes.find(type => type.id === this[form + 'Equipment'].equipment_type_id);
            if (!equipmentType) return;

            const mask = equipmentType.mask;
            let serialNumber = '';

            for (let char of mask) {
                switch (char) {
                    case 'N':
                        serialNumber += Math.floor(Math.random() * 10);  // Генерирует цифру (0-9)
                        break;
                    case 'A':
                        serialNumber += String.fromCharCode(65 + Math.floor(Math.random() * 26));  // Генерирует заглавную букву (A-Z)
                        break;
                    case 'a':
                        serialNumber += String.fromCharCode(97 + Math.floor(Math.random() * 26));  // Генерирует строчную букву (a-z)
                        break;
                    case 'X':
                        serialNumber += Math.random() < 0.5
                            ? String.fromCharCode(65 + Math.floor(Math.random() * 26))  // Генерирует заглавную букву (A-Z)
                            : Math.floor(Math.random() * 10);  // или цифру (0-9)
                        break;
                    case 'Z':
                        serialNumber += ['-', '_', '@'][Math.floor(Math.random() * 3)];  // Случайный выбор из "-", "_", "@"
                        break;
                    default:
                        serialNumber += char;  // Если есть неожиданный символ, просто добавьте его
                }
            }

            this[form + 'Equipment'].serial_number = serialNumber;
        },
        resetCreationForm() {
            this.newEquipment = {
                equipment_type_id: '',
                serial_number: '',
                desc: ''
            };
            this.errors.newEquipment = { equipment_type_id: '', serial_number: '' };
            this.successMessage = '';  // Сброс сообщения об успехе
        },
        cancelEdit() {
            this.selectedEquipment = null;
            this.errors.selectedEquipment = { equipment_type_id: '', serial_number: '' };
            this.successMessage = '';  // Сброс сообщения об успехе
        },
    },
    mounted() {
        this.fetchEquipment();  // Загрузить начальный список оборудования при монтировании
        this.fetchEquipmentTypes();
    }
};
</script>

<style scoped>
</style>
