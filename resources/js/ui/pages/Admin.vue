<template>
  <div class="admin-login-page">
    <h1>Вход в панель администратора</h1>
    <form @submit.prevent="login" class="login-form">
      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          v-model="email"
          placeholder="Введите email"
          required
        />
      </div>
      
      <div class="form-group">
        <label for="password">Пароль</label>
        <input
          type="password"
          id="password"
          v-model="password"
          placeholder="Введите пароль"
          required
        />
      </div>
      
      <div class="form-group">
        <button type="submit" class="submit-button" :disabled="loading">
          Войти
        </button>
      </div>
      
      <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default {
  name: "Admin",
  setup() {
    const email = ref("");
    const password = ref("");
    const errorMessage = ref("");
    const loading = ref(false);
    const router = useRouter();

    const login = async () => {
    loading.value = true;
    errorMessage.value = "";

    try {
      const response = await axios.post("/api/support-login", {
        email: email.value,
        password: password.value,
      });

      if (response.data.status === "success") {
        sessionStorage.setItem("is_admin", true);
        sessionStorage.setItem("admin_email", email.value);
        router.push("/");
      }
    } catch (error) {
      errorMessage.value = "Неверный email или пароль.";
    } finally {
      loading.value = false;
    }
  };

    return {
      email,
      password,
      errorMessage,
      loading,
      login,
    };
  },
};
</script>

<style scoped>
.admin-login-page {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input {
  width: 100%;
  padding: 10px;
  margin: 5px 0;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.submit-button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
}

.submit-button:disabled {
  background-color: #ddd;
  cursor: not-allowed;
}

.error-message {
  color: red;
  text-align: center;
  margin-top: 10px;
}
</style>
