<template>
  <div>
    <h2>Список отелей</h2>
    <div class="combined-input">
      <input 
        type="text" 
        v-model="searchCity" 
        placeholder="Введите город или выберите из списка"
        @input="onSearchCityInput"
      >
      <select v-model="selectedCity" @change="filterHotelsBySelectedCity">
        <option value="">Выберите город</option>
        <option v-for="city in uniqueCities" :key="city" :value="city">
          {{ city }}
        </option>
      </select>
    </div>

    <ul v-if="hotelsFiltered.length > 0">
      <li v-for="hotel in hotelsFiltered" :key="hotel.id" @click="goToHotelPage(hotel.id)" style="cursor: pointer;">
        {{ hotel.name }} - {{ hotel.location }} - {{ hotel.price }}
      </li>
    </ul>
    <p v-else-if="!hotelsFiltered.length && !hotelStore.loading && (searchCity.trim() === '' && selectedCity === '')">Нет отелей в данном городе</p>
    <p v-else>Введите название города или выберите из списка...</p>

    <ChatSupport />
  </div>
</template>

<script>
import { defineComponent, ref, onMounted, watch } from 'vue';
import ChatSupport from '/OSPanel/home/laravel.vue/resources/js/ui/components/ChatSupport.vue';
import { useHotelStore } from '/OSPanel/home/laravel.vue/resources/js/infrastructure/stores/hotelStore.js';
import { useRouter } from 'vue-router';

export default defineComponent({
  components: {
    ChatSupport
  },
  setup() {
    const hotelStore = useHotelStore();
    const searchCity = ref('');
    const selectedCity = ref('');
    const router = useRouter();
    const uniqueCities = ref([]);

    onMounted(async () => {
      await hotelStore.fetchHotels();

      const response = await fetch('/api/unique-locations');
      const data = await response.json();
      uniqueCities.value = data.uniqueLocations;
    });

    const hotelsFiltered = ref([]);
    const filterHotels = () => {
      if (searchCity.value.trim() === '' && selectedCity.value === '') {
        hotelsFiltered.value = [];
      } else {
        let filteredHotels = hotelStore.hotels;
        
        if (searchCity.value.trim()) {
          filteredHotels = filteredHotels.filter(hotel =>
            hotel.location.toLowerCase().includes(searchCity.value.toLowerCase())
          );
        }

        if (selectedCity.value) {
          filteredHotels = filteredHotels.filter(hotel =>
            hotel.location.toLowerCase() === selectedCity.value.toLowerCase()
          );
        }

        hotelsFiltered.value = filteredHotels;
      }
    };

    watch([searchCity, selectedCity], filterHotels);

    const filterHotelsBySelectedCity = () => {
      if (selectedCity.value) {
        hotelsFiltered.value = hotelStore.hotels.filter(hotel =>
          hotel.location.toLowerCase() === selectedCity.value.toLowerCase()
        );
      } else {
        filterHotels();
      }
    };

    const goToHotelPage = (hotelId) => {
      router.push({ name: 'HotelPage', params: { id: hotelId } });
    };

    const onSearchCityInput = () => {
      if (uniqueCities.value.includes(searchCity.value.trim())) {
        selectedCity.value = searchCity.value.trim();
      } else if (searchCity.value.trim() === '') {
        selectedCity.value = '';
      }
    };

    watch(selectedCity, (newValue) => {
      if (newValue) {
        searchCity.value = newValue;
      } else {
        searchCity.value = '';
      }
    });

    watch(searchCity, (newValue) => {
      if (newValue.trim() === '') {
        selectedCity.value = '';
      }
    });

    return {
      searchCity,
      selectedCity,
      hotelsFiltered,
      uniqueCities,
      hotelStore,
      goToHotelPage,
      filterHotelsBySelectedCity,
      onSearchCityInput
    };
  },
});
</script>

<style scoped>
.combined-input {
  display: flex;
  gap: 10px;
}

input, select {
  flex-grow: 1;
}
</style>
