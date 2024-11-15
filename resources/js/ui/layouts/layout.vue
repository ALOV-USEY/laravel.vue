<template>
  <div id="nav">
    <div id="logo">
      <router-link to="/">MySite</router-link>
    </div>

    <div id="links">
      <router-link to="/find" class="nav-link">Find</router-link>
      <router-link to="/" class="nav-link">Home</router-link>
      <router-link v-if="!isAuthenticated" to="/admin" class="nav-link">Admin</router-link>
      <router-link v-if="isAdmin" to="/second-chat" class="nav-link">Second Chat</router-link>
      <router-link v-if="isAdmin" to="/hotel-manager" class="nav-link">Hotel Manager</router-link>
    </div>

    <div id="user-info" v-if="isAuthenticated">
      <span class="welcome-message" v-if="!isAdmin">Привет, {{ userName }}!</span>
      <span class="admin-email" v-if="isAdmin">Admin: {{ adminEmail }}</span>
      <button @click="logout" class="logout-btn">Выйти</button>
    </div>

    <div id="auth-links" v-else>
      <router-link to="/login" class="auth-link">Login</router-link>
      <router-link to="/register" class="auth-link">Register</router-link>
    </div>
  </div>
</template>

<script>
import { useChatStore } from '/OSPanel/home/laravel.vue/resources/js/infrastructure/stores/chatStore';

export default {
  data() {
    return {
      isAuthenticated: false,
      isAdmin: false,
      adminEmail: '',
    };
  },
  mounted() {
    this.checkAuthentication();
  },
  watch: {
    '$route'(to, from) {
      this.checkAuthentication();
    }
  },
  computed: {
    userName() {
      return this.chatStore.user ? this.chatStore.user.name : '';
    },
  },
  setup() {
    const chatStore = useChatStore();
    return { chatStore };
  },
  methods: {
    checkAuthentication() {
      const user = JSON.parse(localStorage.getItem('user'));
      const isAdmin = sessionStorage.getItem('is_admin');
      const adminEmail = sessionStorage.getItem('admin_email');

      if (user) {
        this.isAuthenticated = true;
        this.isAdmin = false;
        this.chatStore.user = user;
      } 
      else if (isAdmin) {
        this.isAuthenticated = true;
        this.isAdmin = true;
        this.adminEmail = adminEmail;
      } else {
        this.isAuthenticated = false;
      }
    },
    logout() {
      if (this.isAdmin) {
        sessionStorage.removeItem('is_admin');
        sessionStorage.removeItem('admin_email');
      } 
      else {
        localStorage.removeItem('user');
        this.chatStore.logout();
      }

      this.isAuthenticated = false;
      this.isAdmin = false;
      this.$router.push('/');
    }
  }
};
</script>

<style scoped>
#nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  background-color: #2c3e50;
  color: white;
  font-family: 'Arial', sans-serif;
  border-bottom: 2px solid #34495e;
}

#logo {
  font-size: 1.5rem;
  font-weight: bold;
}

#links {
  display: flex;
  gap: 20px;
}

.nav-link {
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  transition: background-color 0.3s ease;
  border-radius: 5px;
}

.nav-link:hover {
  background-color: #2980b9;
}

#user-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.welcome-message {
  font-size: 1rem;
}

.admin-email {
  font-size: 1rem;
  font-weight: bold;
}

.logout-btn {
  padding: 5px 10px;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.logout-btn:hover {
  background-color: #c0392b;
}

#auth-links {
  display: flex;
  gap: 15px;
}

.auth-link {
  color: white;
  text-decoration: none;
  padding: 5px 10px;
  background-color: #3498db;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.auth-link:hover {
  background-color: #2980b9;
}
</style>
