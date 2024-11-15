import { ref } from 'vue';
import axios from 'axios';
import MessageInputDTO from '../../infrastructure/transport/in/message.js';
import MessageOutputDTO from '../../infrastructure/transport/out/dto/MessageOutputDTO.js';

export default function useChat() {
    const messages = ref([]);
    const errors = ref([]);

    const getMessages = async () => {
        try {
            const response = await axios.get('/api/messages', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
            messages.value = response.data.messages.map(message => new MessageOutputDTO(message));
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    };

    const addMessage = async (form) => {
        errors.value = [];

        try {
            const dto = new MessageDTO(form.message);
            const response = await axios.post('/api/send', dto, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });
            messages.value.push(new MessageOutputDTO(response.data.message));
        } catch (error) {
            console.error('Error adding message:', error);
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    };

    return {
        messages,
        errors,
        getMessages,
        addMessage
    };
}
