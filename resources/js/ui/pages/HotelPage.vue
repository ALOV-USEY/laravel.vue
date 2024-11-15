<template>
  <div>
    <h2>Страница отеля</h2>

    <!-- Проверка наличия отеля и отображение его данных -->
    <div v-if="hotel">
      <h3>{{ hotel.name }}</h3>
      <p>Местоположение: {{ hotel.location }}</p>
      <p>Описание: {{ hotel.description }}</p>
      <p>Цена: {{ hotel.price }}</p>
    </div>
    <p v-else>Отель не найден</p>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import { useHotelStore } from '/OSPanel/home/laravel.vue/resources/js/infrastructure/stores/hotelStore.js';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const hotelStore = useHotelStore();
    const router = useRouter();
    const hotelId = ref(router.currentRoute.value.params.id);

    const hotel = computed(() => {
      return hotelStore.hotels.find(h => h.id === parseInt(hotelId.value));
    });

    return {
      hotel
    };
  }
};
</script>
