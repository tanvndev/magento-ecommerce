<template>
    <div>
      <div v-for="message in messages" :key="message.id">
        <strong>{{ message.user.name }}:</strong> {{ message.text }}
      </div>
      
      <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Enter message..." />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const messages = ref([]);
  const newMessage = ref('');
  
  const sendMessage = async () => {
    if (newMessage.value.trim() !== '') {
      await axios.post('/send-message', { message: newMessage.value });
      newMessage.value = '';  // Clear input after sending
    }
  };
  
  // Lắng nghe sự kiện phát sóng từ Laravel Echo
  onMounted(() => {
    window.Echo.channel('chat')
      .listen('.message.sent', (e) => {
        messages.value.push({
          user: e.user,
          text: e.message
        });
      });
  });
  </script>
  