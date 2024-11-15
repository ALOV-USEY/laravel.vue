<template>
    <div class="register">
      <h2>Регистрация</h2>
      <form @submit.prevent="registerUser">
        <div>
          <label for="name">Имя</label>
          <input type="text" id="name" v-model="name" required />
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" required />
        </div>
        <div>
          <label for="password">Пароль</label>
          <input type="password" id="password" v-model="password" required />
        </div>
        <div>
          <label for="password_confirmation">Подтверждение пароля</label>
          <input type="password" id="password_confirmation" v-model="password_confirmation" required />
        </div>
        <button type="submit">Зарегистрироваться</button>
      </form>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        errorMessage: '',
      };
    },
    methods: {
      async registerUser() {
        try {
          const response = await axios.post('/api/register', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          });
  
          const user = response.data.user;
          localStorage.setItem('user', JSON.stringify(user));
  
          this.$router.push('/');
        } catch (error) {
          if (error.response && error.response.data.errors) {
            this.errorMessage = Object.values(error.response.data.errors).join(', ');
          } else {
            this.errorMessage = 'Что-то пошло не так, попробуйте еще раз.';
          }
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .register {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    background-color: #f8f8f8;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  h2 {
    text-align: center;
  }
  
  form {
    display: flex;
    flex-direction: column;
  }
  
  label {
    margin-top: 10px;
  }
  
  input {
    padding: 8px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  
  button {
    margin-top: 20px;
    padding: 10px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #2980b9;
  }
  
  .error {
    color: red;
    margin-top: 10px;
  }
  </style>
  