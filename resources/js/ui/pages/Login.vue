<template>
  <div>
    <h2>Логин</h2>
    <form @submit.prevent="loginUser">
      <div>
        <label for="email">Электронная почта:</label>
        <input type="email" v-model="email" id="email" required />
      </div>
      <div>
        <label for="password">Пароль:</label>
        <input type="password" v-model="password" id="password" required />
      </div>
      <button type="submit">Войти</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async loginUser() {
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password
        });

        localStorage.setItem('token', response.data.token);

        localStorage.setItem('user', JSON.stringify(response.data.user)); 

        alert('Вход успешен!');
        this.$router.push('/');
      } catch (error) {
        console.error(error);
        alert('Произошла ошибка при входе');
      }
    }
  }
};
</script>
