import { defineStore } from 'pinia';
import axios from 'axios';

export const useChatStore = defineStore({
  id: 'chat',
  state: () => ({
    messages: [],
    errors: [],
    user: null,
    isAuthenticated: false,
  }),
  actions: {
    checkAuthStatus() {
      this.isAuthenticated = !!localStorage.getItem('token');
    },

    async getMessages() {
      this.checkAuthStatus();
      if (!this.isAuthenticated) return;

      try {
        const response = await axios.get('/api/messages', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });

        if (Array.isArray(response.data)) {
          const currentUserId = this.user ? this.user.id : null;
          if (currentUserId) {
            this.messages = response.data.filter(msg => msg.user_id === currentUserId);
          }
        }
      } catch (error) {
        console.error('Error fetching messages:', error);
      }
    },

    async getUser() {
      this.checkAuthStatus();
      if (!this.isAuthenticated) return;

      try {
        const response = await axios.get('/api/user', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });

        if (response.data && response.data.user) {
          this.user = response.data.user;
        } else {
          console.error('No user data found');
        }
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },

    async addMessage(form) {
      this.checkAuthStatus();
      if (!this.isAuthenticated) return;

      try {
        const response = await axios.post('/api/send', {
          user_id: form.user_id,
          message: form.message,
        }, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });

        if (response.data) {
          this.messages.push(response.data);
        }
      } catch (error) {
        console.error('Error adding message:', error);
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        }
      }
    },

    logout() {
      localStorage.removeItem('token');
      this.user = null;
      this.messages = [];
      this.isAuthenticated = false;
    },
  },
});
