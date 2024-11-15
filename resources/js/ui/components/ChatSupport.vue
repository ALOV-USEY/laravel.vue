<template>
  <div v-if="chatStore.user" class="chat-container">
    <div class="chat-box">
      <div class="messages" ref="messagesContainer">
        <div v-for="(message, index) in chatStore.messages" :key="index" class="message">
          <div class="message-text">{{ message.message }}</div>
        </div>
      </div>
      <div class="input-container">
        <input 
          v-model="newMessage" 
          placeholder="Напишите сообщение..." 
          class="message-input"
        />
        <button @click="sendMessage" class="send-button">Отправить</button>
      </div>
    </div>
  </div>
  <div v-else>
    <p>Пожалуйста, авторизуйтесь, чтобы начать чат.</p>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import { useChatStore } from '/OSPanel/home/laravel.vue/resources/js/infrastructure/stores/chatStore';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default {
  setup() {
    const chatStore = useChatStore();
    const newMessage = ref('');
    const messagesContainer = ref(null);
    let echoChannel = null;

    const echo = new Echo({
      broadcaster: 'pusher',
      key: 'e0ca9d7db1936641d66a',
      cluster: 'ap2',
      forceTLS: true,
      encrypted: true,
    });

    onMounted(async () => {
      console.log('Mounting ChatSupport component...');
      await chatStore.getUser();
      await chatStore.getMessages();
      console.log('User:', chatStore.user);
      console.log('Messages:', chatStore.messages);

      if (chatStore.user && chatStore.user.id) {
        echoChannel = echo.channel(`chat.${chatStore.user.id}`)
          .listen('MessageSent', (event) => {
            chatStore.messages.push(event.message);
            scrollToBottom();
          });
      } else {
        console.log('Пользователь не авторизован или отсутствует id');
      }
    });

    onUnmounted(() => {
      if (chatStore.user && chatStore.user.id && echoChannel) {
        echo.leaveChannel(`chat.${chatStore.user.id}`);
      }
    });

    const sendMessage = async () => {
      if (!chatStore.user || !chatStore.user.id) {
        console.log('Пользователь не авторизован');
        return;
      }

      if (newMessage.value.trim() !== '') {
        try {
          await chatStore.addMessage({
            user_id: chatStore.user.id,
            message: newMessage.value,
          });
          newMessage.value = '';
          scrollToBottom();
        } catch (error) {
          console.error('Ошибка при отправке сообщения:', error);
        }
      }
    };

    const scrollToBottom = () => {
      if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
      }
    };

    return {
      chatStore,
      newMessage,
      sendMessage,
      scrollToBottom,
      messagesContainer,
    };
  },
};
</script>

<style scoped>
.chat-container {
  display: flex;
  flex-direction: column;
  height: 100%;
}
.chat-box {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  overflow-y: auto;
}
.messages {
  flex-grow: 1;
  padding: 10px;
  overflow-y: scroll;
}
.message {
  margin-bottom: 10px;
}
.message-text {
  background-color: #f1f1f1;
  padding: 10px;
  border-radius: 5px;
  max-width: 80%;
  word-wrap: break-word;
}
.input-container {
  display: flex;
  padding: 10px;
  background-color: #fff;
  border-top: 1px solid #ccc;
}
.message-input {
  flex-grow: 1;
  padding: 10px;
  margin-right: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.send-button {
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.send-button:hover {
  background-color: #0056b3;
}
</style>
