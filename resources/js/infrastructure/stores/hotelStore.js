import { defineStore } from 'pinia';
import { fetchHotels } from '../plugins/api';

export const useHotelStore = defineStore({
  id: 'hotel',

  state: () => ({
    hotels: [],
    loading: false,
    error: null,
  }),

  getters: {
    hotelsCount() {
      return this.hotels.length;
    }
  },

  actions: {
    async fetchHotels() {
      try {
        this.loading = true;
        console.log('Fetching hotels...');
        const response = await fetchHotels();
        console.log('Response:', response);
        
        if (response && response.hotels && Array.isArray(response.hotels)) {
          this.hotels = response.hotels;
        } else {
          console.error('Ошибка загрузки отелей: Некорректный формат ответа');
          this.error = 'Некорректный формат ответа';
        }
      } catch (error) {
        console.error('Ошибка загрузки отелей:', error);
        this.error = error.message;
      } finally {
        this.loading = false;
      }
    },
  },
});
