<template>
    <div class="grand-container">
        <h2>СПИСОК ОБОРУДОВАНИЯ</h2>

        <!-- Выбор типа поиска -->
        <div class="el-search-container">
            <h3 style="text-align: center; margin-top: 0;">Поиск оборудования</h3>
            <div>
                <label>
                    <input type="radio" v-model="searchType" value="serial_number"> По серийному номеру
                </label>
                <label>
                    <input type="radio" v-model="searchType" value="desc"> По описанию
                </label>
                <label>
                    <input type="radio" v-model="searchType" value="q"> Общий поиск
                </label>
            </div>
            <div>
                <input v-model="searchQuery" placeholder="Введите ваш запрос..." />
                <button @click="fetchEquipment">Найти</button>
            </div>
        </div>

        <div class="el-container">
            <!-- Глобальный индикатор загрузки -->
            <div v-if="loading" class="loading">Загрузка...</div>
            <ul v-if="!loading">
                <li v-for="equipment in equipmentList" :key="equipment.id">
                    {{ equipment.serial_number }} - {{ equipment.desc }}
                    <div>
                        <button @click="editEquipment(equipment)">Изменить</button>
                        <button @click="deleteEquipment(equipment.id)">Удалить</button>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Управление пагинацией -->
        <div v-if="pagination.total > pagination.perPage">
            <button @click="fetchEquipment(pagination.currentPage - 1)" :disabled="pagination.currentPage === 1">
                Назад
            </button>
            <button @click="fetchEquipment(pagination.currentPage + 1)" :disabled="pagination.currentPage === pagination.totalPages">
                Вперед
            </button>
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

        <!-- Формы добавления нового оборудования -->
        <div v-for="(equipment, index) in newEquipments" :key="index" class="el-create-container">
            <h3>Добавить новое оборудование {{ index + 1 }}</h3>

            <div class="el-create-select">
                <span>Тип оборудования:</span>
                <select v-model="equipment.equipment_type_id">
                    <option v-for="type in equipmentTypes" :key="type.id" :value="type.id">
                        {{ type.name }}
                    </option>
                </select>
            </div>
            <!-- Ошибка для типа оборудования -->
            <div v-if="bulkErrors[index]?.equipment_type_id" class="error">{{ bulkErrors[index].equipment_type_id[0] }}</div>

            <input v-model="equipment.serial_number" placeholder="Серийный номер" />
            <button @click="generateSerialNumber('new', index)">Сгенерировать серийный номер</button>
            <!-- Ошибка для серийного номера -->
            <div v-if="bulkErrors[index]?.serial_number" class="error">{{ bulkErrors[index].serial_number[0] }}</div>

            <input v-model="equipment.desc" placeholder="Описание" />

            <div class="el-create-buttons">
                <button @click="removeEquipmentForm(index)" v-if="newEquipments.length > 1">Удалить</button>
            </div>
        </div>

        <!-- Кнопки управления формами добавления -->
        <div class="el-create-buttons">
            <button @click="addEquipmentForm">Добавить ещё одно оборудование</button>
            <button @click="createEquipment">Добавить</button>
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
            newEquipments: [this.createNewEquipment()],
            errors: {
                newEquipments: [],
                selectedEquipment: {
                    equipment_type_id: '',
                    serial_number: ''
                }
            },
            loading: false,
            creating: false,
            updating: false,
            successMessage: '',
            pagination: {
                currentPage: 1,
                total: 0,
                perPage: 10,
                totalPages: 0
            },
            creatingIndex: null,
            bulkErrors: {},
        };
    },
    methods: {
        createNewEquipment() {
            return {
                equipment_type_id: '',
                serial_number: '',
                desc: ''
            };
        },
        addEquipmentForm() {
            this.newEquipments.push(this.createNewEquipment());
        },
        removeEquipmentForm(index) {
            if (this.newEquipments.length > 1) {
                this.newEquipments.splice(index, 1);
                this.updateFormIndices();  // Обновление индексов для маппинга ошибок
            }
        },
        fetchEquipment(page = 1) {
            this.loading = true;
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
                    this.loading = false;
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
            this.updating = true;
            this.successMessage = '';

            axios
                .put(`/api/equipment/${this.selectedEquipment.id}`, this.selectedEquipment)
                .then(() => {
                    this.fetchEquipment();
                    this.selectedEquipment = null;
                    this.successMessage = "Оборудование успешно обновлено!";
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
                    this.updating = false;
                });
        },
        deleteEquipment(id) {
            this.successMessage = '';
            axios
                .delete(`/api/equipment/${id}`)
                .then(() => {
                    this.fetchEquipment();
                    this.successMessage = 'Оборудование успешно удалено!';
                })
                .catch((error) => {
                    console.error('Ошибка при удалении оборудования:', error);
                });
        },
        createEquipment() {
            this.errors.newEquipments = [];
            this.loading = true;  // Запускаем индикатор загрузки для массовой операции
            this.successMessage = '';
            const payload = { equipment: this.newEquipments };

            axios
                .post('/api/equipment/bulk', payload)
                .then((response) => {
                    this.bulkErrors = {};  // Сбрасываем все массовые ошибки
                    let successfulCount = 0;

                    // Обработка успешных ответов о создании
                    response.data.success.forEach((equipment, index) => {
                        successfulCount++;
                        // Удаляем успешно созданное оборудование из списка форм
                        this.newEquipments.splice(index - successfulCount + 1, 1);
                    });

                    // Отображение сообщения об успехе, если было добавлено оборудование
                    if (successfulCount > 0) {
                        this.successMessage = "Оборудование успешно добавлено!";
                    }

                    // Обработка ошибок для конкретных форм
                    this.bulkErrors = response.data.errors;

                    // Реинициализация сообщений об ошибках и форм
                    this.updateFormIndices();
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        // Отображение сообщений об ошибках, если есть ответ с ошибками валидации
                        Object.keys(error.response.data.errors).forEach((key) => {
                            const errorMessage = error.response.data.errors[key];
                            const index = key.split('.')[1]; // Извлекаем индекс из ключа ошибки
                            this.bulkErrors[index] = errorMessage.reduce((acc, curr) => {
                                if (curr.includes('equipment_type_id')) acc.equipment_type_id = curr;
                                if (curr.includes('serial_number')) acc.serial_number = curr;
                                return acc;
                            }, {});
                        });
                    } else {
                        console.error('Ошибка при создании оборудования:', error);
                    }
                })
                .finally(() => {
                    this.loading = false;  // Останавливаем индикатор загрузки
                });
        },
        updateFormIndices() {
            // Сброс ошибок и обновление номеров форм в соответствии с текущим порядком в массиве newEquipments
            const newBulkErrors = {};
            this.newEquipments.forEach((_, index) => {
                if (this.bulkErrors[index]) {
                    newBulkErrors[index] = this.bulkErrors[index];
                }
            });
            this.bulkErrors = newBulkErrors;
        },
        generateSerialNumber(form, index = null) {
            const equipment = index !== null ? this.newEquipments[index] : this[form + 'Equipment'];
            const equipmentType = this.equipmentTypes.find(type => type.id === equipment.equipment_type_id);
            if (!equipmentType) return;

            const mask = equipmentType.mask;
            let serialNumber = '';

            for (let char of mask) {
                switch (char) {
                    case 'N':
                        serialNumber += Math.floor(Math.random() * 10);
                        break;
                    case 'A':
                        serialNumber += String.fromCharCode(65 + Math.floor(Math.random() * 26));
                        break;
                    case 'a':
                        serialNumber += String.fromCharCode(97 + Math.floor(Math.random() * 26));
                        break;
                    case 'X':
                        serialNumber += Math.random() < 0.5
                            ? String.fromCharCode(65 + Math.floor(Math.random() * 26))
                            : Math.floor(Math.random() * 10);
                        break;
                    case 'Z':
                        serialNumber += ['-', '_', '@'][Math.floor(Math.random() * 3)];
                        break;
                    default:
                        serialNumber += char;
                }
            }

            equipment.serial_number = serialNumber;
        },
        resetCreationForm() {
            this.newEquipments = [this.createNewEquipment()];
            this.errors.newEquipments = [];
            this.bulkErrors = {};
            this.successMessage = '';
        },
        cancelEdit() {
            this.selectedEquipment = null;
            this.errors.selectedEquipment = { equipment_type_id: '', serial_number: '' };
            this.successMessage = '';
        },
    },
    mounted() {
        this.fetchEquipment();
        this.fetchEquipmentTypes();
    }
};
</script>

<style scoped>
</style>
