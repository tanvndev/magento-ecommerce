// plugins/pusher.js
import Pusher from 'pusher-js';

Pusher.logToConsole = true;

const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true
});

export default pusher;
