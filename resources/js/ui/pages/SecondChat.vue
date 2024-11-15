<template>
  <div class="users-tabs">
    <div class="user-select">
      <select v-model="selectedUserId" @change="onUserChange">
        <option value="" disabled>Выберите пользователя</option>
        <option v-for="user in users" :key="user.id" :value="user.id">
          {{ user.name }}
        </option>
      </select>
    </div>

    <div v-if="selectedUser" class="messages-container">
      <h3>Сообщения от {{ selectedUser.name }}</h3>
      <div class="messages">
        <div v-for="(message, index) in selectedUserMessages" :key="index" class="message">
          <p>{{ message.message }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted, computed } from "vue";
import axios from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

export default {
  name: "UsersTab",
  setup() {
    const users = ref([]);
    const selectedUserId = ref(null);
    const selectedUserMessages = ref([]);
    let echo = null;

    const initializeEcho = () => {
      echo = new Echo({
        broadcaster: "pusher",
        key: "e0ca9d7db1936641d66a",
        cluster: "ap2",
        forceTLS: true,
        encrypted: true,
      });

      echo.channel("chat").listen("MessageSent", (event) => {
        handleIncomingMessage(event.message);
      });
    };

    const handleIncomingMessage = (message) => {
      if (selectedUser.value && selectedUser.value.id === message.user_id) {
        selectedUserMessages.value.push(message);
      }
    };

    const selectedUser = computed(() => {
      return users.value.find((user) => user.id === selectedUserId.value) || null;
    });

    const getUsers = async () => {
      try {
        const response = await axios.get("/api/users");
        users.value = response.data;
      } catch (error) {
        console.error("Ошибка при загрузке пользователей:", error);
      }
    };

    const getMessages = async (userId) => {
      try {
        const response = await axios.get("/api/messages");
        selectedUserMessages.value = response.data.filter(
          (message) => message.user_id === userId
        );
      } catch (error) {
        console.error("Ошибка при загрузке сообщений:", error);
      }
    };

    const onUserChange = () => {
      if (selectedUserId.value) {
        getMessages(selectedUserId.value);
      } else {
        selectedUserMessages.value = [];
      }
    };

    const disconnectEcho = () => {
      if (echo) {
        echo.disconnect();
      }
    };

    onMounted(() => {
      initializeEcho();
      getUsers();
    });

    onUnmounted(() => {
      disconnectEcho();
    });

    return {
      users,
      selectedUser,
      selectedUserId,
      selectedUserMessages,
      onUserChange,
    };
  },
};
</script>

<style scoped>
/* Общие стили для страницы */
.users-tabs {
  font-family: Arial, sans-serif;
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

/* Стили для выпадающего списка */
.user-select {
  margin-bottom: 1.5em;
  display: flex;
  align-items: center;
  justify-content: center;
}

.user-select select {
  padding: 10px 15px;
  font-size: 1rem;
  border-radius: 5px;
  border: 1px solid #ccc;
  width: 100%;
  max-width: 400px;
  appearance: none; /* Убирает стандартные стили браузера */
  background: #fff url('data:image/svg+xml;utf8,<svg viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><polygon points="70,100 10,40 130,40" style="fill:%23999"/></svg>') no-repeat right 10px center;
  background-size: 1em;
}

.user-select select:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0px 0px 4px rgba(0, 123, 255, 0.4);
}

/* Стили для вкладок */
.tabs {
  display: flex;
  gap: 10px;
  justify-content: center;
  margin-bottom: 1em;
}

.tab {
  cursor: pointer;
  padding: 10px 20px;
  font-size: 1rem;
  color: #333;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #fff;
  transition: background-color 0.3s, color 0.3s;
}

.tab:hover {
  background-color: #007bff;
  color: #fff;
}

.tab-active {
  background-color: #007bff;
  color: #fff;
  border-color: #007bff;
}

/* Контейнер для сообщений */
.messages-container {
  margin-top: 20px;
  background-color: #fff;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
}

/* Стили для сообщений */
.message {
  margin: 10px 0;
  padding: 10px;
  background-color: #f1f1f1;
  border-radius: 5px;
  border-bottom: 1px solid #ddd;
  font-size: 0.95rem;
}

.message p {
  margin: 0;
  color: #555;
}

/* Заголовок для выбранного пользователя */
h3 {
  color: #007bff;
  font-weight: 600;
  margin-bottom: 1em;
  text-align: center;
}

/* Адаптивность */
@media (max-width: 500px) {
  .tab {
    padding: 8px 12px;
    font-size: 0.9rem;
  }

  .user-select select {
    width: 100%;
  }

  .messages-container {
    padding: 10px;
  }
}
</style>
