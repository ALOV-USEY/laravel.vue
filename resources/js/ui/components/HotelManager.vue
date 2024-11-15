<template>
  <div class="hotel-manager">
    <h1>Управление отелями</h1>
    <form @submit.prevent="submitHotel">
      <input type="hidden" v-model="hotel.id">
      <div>
        <label for="name">Имя отеля:</label>
        <input type="text" v-model="hotel.name" required>
      </div>
      <div>
        <label for="location">Расположение:</label>
        <input type="text" v-model="hotel.location" required>
      </div>
      <div>
        <label for="description">Описание:</label>
        <textarea v-model="hotel.description" required></textarea>
      </div>
      <div>
        <label for="price">Цена:</label>
        <input type="number" v-model="hotel.price" step="0.01" required>
      </div>
      <button type="submit">{{ isEditing ? 'Обновить отель' : 'Добавить отель' }}</button>
    </form>

    <h2>Список отелей</h2>
    <ul>
      <li v-for="h in hotels" :key="h.id">
        <strong>{{ h.name }}</strong> - {{ h.location }} 
        <button @click="editHotel(h)">Редактировать</button>
        <button @click="deleteHotel(h.id)">Удалить</button>
      </li>
    </ul>

    <div v-if="error" class="error">{{ error }}</div>
    <div v-if="success" class="success">Действие выполнено успешно!</div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';

export default {
  name: 'HotelManager',
  setup() {
    const hotels = ref([]);
    const hotel = ref({ name: '', location: '', description: '', price: null });
    const isEditing = ref(false);
    const error = ref(null);
    const success = ref(null);

    const fetchHotels = async () => {
      try {
        const response = await axios.get('/api/hotels', { withCredentials: true });
        hotels.value = response.data.hotels;
      } catch (err) {
        if (err.response && err.response.status === 401) {
          error.value = 'Вы не авторизованы. Пожалуйста, войдите в систему.';
        } else {
          error.value = 'Ошибка';
        }
        console.error(err);
      }
    };

    const submitHotel = async () => {
      error.value = null;
      success.value = null;
      try {
        if (isEditing.value) {
          await axios.put(`/api/hotels/${hotel.value.id}`, hotel.value, { withCredentials: true });
        } else {
          await axios.post('/api/hotels', hotel.value, { withCredentials: true });
        }
        success.value = 'Отель успешно добавлен/обновлен';
        hotel.value = { name: '', location: '', description: '', price: null };
        isEditing.value = false;
        await fetchHotels();
      } catch (err) {
        if (err.response && err.response.status === 401) {
          error.value = 'Вы не авторизованы. Пожалуйста, войдите в систему.';
        } else {
          error.value = 'Ошибка';
        }
      }
    };

    const editHotel = (h) => {
      hotel.value = { ...h };
      isEditing.value = true;
    };

    const deleteHotel = async (id) => {
      if (confirm('Вы уверены, что хотите удалить этот отель?')) {
        try {
          await axios.delete(`/api/hotels/${id}`, { withCredentials: true });
          success.value = 'Отель успешно удален';
          await fetchHotels();
        } catch (err) {
          error.value = 'Ошибка';
        }
      }
    };

    onMounted(fetchHotels);

    return { hotels, hotel, isEditing, submitHotel, editHotel, deleteHotel, error, success };
  },
};
</script>

  
  <style>
  .hotel-manager {
    max-width: 600px;
    margin: 0 auto;
  }
  .error {
    color: red;
  }
  .success {
    color: green;
  }
  </style>
  