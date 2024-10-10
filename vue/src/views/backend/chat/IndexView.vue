<template>
  <MasterLayout>
    <template #template>
      <div class="flex h-full bg-gray-100">
        <!-- Sidebar -->
        <div class="w-1/3 border-r bg-white p-4">
          <input type="text" placeholder="Tìm kiếm..." class="mb-4 w-full rounded border p-2" />
          <div class="scrollable">
            <div
              v-for="user in chats"
              :key="user.id"
              class="chat-item mb-4 flex cursor-pointer items-center border-b p-2"
              @click="selectChat(user.id)"
            >
              <div class="relative">
                <img
                  :src="user.image || 'https://via.placeholder.com/40'"
                  alt=""
                  class="mr-3 rounded-full"
                />
                <div class="status-indicator-1 active"></div>
              </div>
              <div class="w-full">
                <div class="flex w-full items-center justify-between">
                  <div class="header-title">{{ user.fullname }}</div>
                  <small class="me-2 text-gray-500">
                    {{
                      new Date(user.created_at).toLocaleString('vi-VN', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                      })
                    }}
                  </small>
                </div>
                <div class="header-meta w-56 truncate font-bold">
                  {{ user.chat ? user.chat.message : 'No messages yet.' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Chat Box -->
        <div class="flex flex-1 flex-col bg-white" v-if="selectedChatUser !== null">
          <!-- Top: Phần top đứng yên -->
          <div class="flex-none border-b p-4">
            <div class="flex items-center">
              <div class="relative">
                <img
                  :src="selectedChatUser.image || 'https://via.placeholder.com/40'"
                  alt=""
                  class="mr-3 rounded-full"
                />
                <div class="status-indicator active"></div>
              </div>
              <div>
                <div class="header-title">{{ selectedChatUser.fullname }}</div>
                <div class="header-meta">Đang hoạt động</div>
              </div>
            </div>
          </div>

          <!-- Middle: Phần giữa có thể cuộn -->
          <div
            class="flex-grow overflow-y-auto p-4"
            v-if="messages.length > 0"
            ref="messagesContainer"
          >
            <div v-for="message in messages" :key="message.id" class="mb-4">
              <div v-if="message.sender_id === 1" class="mt-2 flex justify-end">
                <p class="inline-block max-w-[70%] rounded bg-blue-100 p-2">
                  {{ message.message }}
                </p>
              </div>
              <div v-else class="mt-2 flex justify-start">
                <img
                  :src="selectedChatUser.avatar || 'https://via.placeholder.com/40'"
                  alt="User Image"
                  class="mr-3 h-8 w-8 rounded-full"
                />
                <p class="inline-block max-w-[70%] rounded bg-gray-200 p-2">
                  {{ message.message }}
                </p>
              </div>
            </div>
          </div>

          <!-- Bottom: Phần input tin nhắn đứng yên -->
          <div class="flex-none border-t p-4">
            <div class="flex items-center">
              <input
                type="text"
                placeholder="Nhập tin nhắn..."
                class="message-input"
                v-model="newMessage"
              />
              <button class="rounded-r bg-blue-500 p-2 text-white" @click="sendMessage">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 7l18 7-7 3-3-7-7-3zm0 0l7 5-3 7-7-5zm0 0l7-5 3 7-7 5z"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { MasterLayout } from '@/components/backend';
import { useCRUD } from '@/composables';

const chats = ref([]);
const selectedChat = ref(null);
const selectedChatUser = ref(null);
const messages = ref([]);
const newMessage = ref('');
const messagesContainer = ref(null);

const { getAll, getOne, create } = useCRUD();

const fetchChatList = async () => {
  try {
    const response = await getAll('chat/list');
    chats.value = response;
  } catch (error) {
    console.error('Error fetching chat list:', error);
  }
};

const handleNewMessage = (event) => {
  const message = event.message;

  // Kiểm tra nếu tin nhắn thuộc về phòng chat hiện tại
  if (selectedChat.value === message.chat_id) {
    messages.value.push(message);
  }
};

// Khi chọn phòng chat, lấy danh sách tin nhắn
const selectChat = async (userId) => {
  selectedChat.value = userId;
  selectedChatUser.value = chats.value.find((user) => user.id === userId);

  await fetchMessages();
};

// Lấy tin nhắn của phòng chat hiện tại
const fetchMessages = async () => {
  try {
    const response = await getOne('chat/message', selectedChat.value);
    messages.value = response;

    // Cuộn đến tin nhắn mới nhất
    await nextTick(); // Đảm bảo DOM đã được cập nhật
    scrollToBottom();
  } catch (error) {
    console.error('Error fetching messages:', error);
  }
};

// Gửi tin nhắn
const sendMessage = async () => {
  if (newMessage.value.trim() === '') return; // Kiểm tra tin nhắn trống

  const message = {
    message: newMessage.value,
    sender_id: 1
  };

  try {
    await create(`send-message/${selectedChat.value}`, {
      message: newMessage.value
    });

    messages.value.push(message);
    newMessage.value = ''; // Xóa input sau khi gửi

    // Cuộn đến tin nhắn mới nhất
    await nextTick(); // Đảm bảo DOM đã được cập nhật
    scrollToBottom();
  } catch (error) {
    console.error('Error sending message:', error);
  }
};

//Hàm cuộn đến tin nhắn mới nhất
const scrollToBottom = () => {
  if (messagesContainer.value) {
    messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
  } else {
    console.error('messagesContainer is not defined');
  }
};

onMounted(async () => {
  await fetchChatList();

  Echo.private(`chat.${selectedChat.value}`).listen('MessageSent', handleNewMessage);
});

onBeforeUnmount(() => {
  // Hủy đăng ký Echo khi component bị hủy
  Echo.leave(`chat.${selectedChat.value}`);
});
</script>

<style scoped>
.chat-item {
  transition: background-color 0.3s;
}

.chat-item:hover {
  background-color: #f0f0f0; /* Màu nền khi hover */
}
.scrollable {
  max-height: calc(100vh - 150px); /* Giới hạn chiều cao cho sidebar */
  overflow-y: auto;
}

.header-title {
  font-size: 0.9375rem;
  font-weight: 500;
}

.header-meta {
  color: #6c757d;
  font-size: 0.8125rem;
}

.message-input {
  flex: 1;
  padding: 0.5rem; /* Tương đương với p-2 */
  border: 1px solid #ccc; /* Tương đương với border */
  border-radius: 0.375rem 0 0 0.375rem; /* Tương đương với rounded-l */
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); /* Tương đương với shadow */
  transition: box-shadow 0.3s; /* Hiệu ứng chuyển tiếp cho box-shadow */
}
.message-input:focus {
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Tạo hiệu ứng box-shadow khi focus */
  outline: none; /* Loại bỏ viền mặc định */
}

.status-indicator,
.status-indicator-1 {
  position: absolute;
  bottom: 0;
  right: 13px;
  width: 10px; /* Kích thước của chấm tròn */
  height: 10px; /* Kích thước của chấm tròn */
  border-radius: 50%; /* Tạo hình tròn */
}

.status-indicator.active {
  background-color: #28a745; /* Màu xanh cho online */
}

.status-indicator-1.active {
  background-color: #ffc107; /* Màu vàng cho offline */
}
</style>
