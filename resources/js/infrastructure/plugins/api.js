import axios from 'axios';

export async function fetchHotels() {
  try {
    const response = await axios.get('/api/hotels');
    return response.data;
  } catch (error) {
    throw error;
  }
}
