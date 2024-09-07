<template>
    <div>
        <h2>Список оборудования</h2>

        <!-- Выбор типа поиска -->
        <label>
            <input type="radio" v-model="searchType" value="serial_number" checked> По серийному номеру
        </label>
        <label>
            <input type="radio" v-model="searchType" value="desc"> По описанию
        </label>

        <input v-model="searchQuery" placeholder="Введите ваш запрос..." />
        <button @click="fetchEquipment">Найти</button>

        <!-- Индикатор загрузки для списка оборудования -->
        <div v-if="loading" class="loading">Загрузка...</div>

        <ul v-else>
            <li v-for="equipment in equipmentList" :key="equipment.id">
                {{ equipment.serial_number }} - {{ equipment.desc }}
                <button @click="editEquipment(equipment)">Изменить</button>
                <button @click="deleteEquipment(equipment.id)">Удалить</button>
            </li>
        </ul>

        <!-- Форма редактирования оборудования -->
        <div v-if="selectedEquipment && equipmentTypes.length > 0">
            <h3>Редактировать оборудование</h3>

            <!-- Выбор типа оборудования -->
            <select v-model="selectedEquipment.equipment_type_id">
                <option v-for="type in equipmentTypes" :key="type.id" :value="type.id">
                    {{ type.name }}
                </option>
            </select>
            <div v-if="errors.selectedEquipment.equipment_type_id" class="error">{{ errors.selectedEquipment.equipment_type_id }}</div>

            <input v-model="selectedEquipment.serial_number" placeholder="Серийный номер" />
            <button @click="generateSerialNumber('selected')">Сгенерировать серийный номер</button>
            <div v-if="errors.selectedEquipment.serial_number" class="error">{{ errors.selectedEquipment.serial_number }}</div>

            <input v-model="selectedEquipment.desc" placeholder="Описание" />
            <button @click="updateEquipment">Сохранить</button>
            <button @click="cancelEdit">Отмена</button>

            <!-- Индикатор загрузки для формы редактирования -->
            <div v-if="updating" class="loading">Сохранение...</div>
            <div v-if="successMessage" class="success">{{ successMessage }}</div> <!-- Отображение сообщения об успехе -->
        </div>

        <!-- Форма добавления нового оборудования -->
        <div>
            <h3>Добавить новое оборудование</h3>
            <select v-model="newEquipment.equipment_type_id">
                <option v-for="type in equipmentTypes" :key="type.id" :value="type.id">
                    {{ type.name }}
                </option>
            </select>
            <div v-if="errors.newEquipment.equipment_type_id" class="error">{{ errors.newEquipment.equipment_type_id }}</div>

            <input v-model="newEquipment.serial_number" placeholder="Серийный номер" />
            <button @click="generateSerialNumber('new')">Сгенерировать серийный номер</button>
            <div v-if="errors.newEquipment.serial_number" class="error">{{ errors.newEquipment.serial_number }}</div>

            <input v-model="newEquipment.desc" placeholder="Описание" />
            <div v-if="errors.newEquipment.desc" class="error">{{ errors.newEquipment.desc }}</div>

            <button @click="createEquipment">Добавить</button>
            <button @click="resetCreationForm">Отменить</button> <!-- Новая кнопка "Отменить" для формы создания -->

            <!-- Индикатор загрузки для формы создания -->
            <div v-if="creating" class="loading">Создание...</div>
            <div v-if="successMessage" class="success">{{ successMessage }}</div> <!-- Отображение сообщения об успехе -->

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
            successMessage: ''  // Состояние сообщения об успехе
        };
    },
    methods: {
        fetchEquipment() {
            this.loading = true;  // Включить индикатор загрузки
            let searchParams = {};
            if (this.searchQuery.trim()) {
                searchParams[this.searchType] = this.searchQuery;
            }

            axios
                .get('/api/equipment', { params: searchParams })
                .then((response) => {
                    this.equipmentList = response.data.data;
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
        this.fetchEquipment();
        this.fetchEquipmentTypes();
    },
};
</script>

<style scoped>
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

.success {
    color: green;
    margin: 10px 0;
    font-size: 1em;
}
</style>
