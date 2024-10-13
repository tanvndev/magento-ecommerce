// plugins/pusher.js
import Pusher from 'pusher-js';
import Cookies from 'js-cookie';

Pusher.logToConsole = true;

const token = Cookies.get('token') ?? null;
const authEndpoint = import.meta.env.VITE_LARAVEL_URL + '/broadcasting/auth';

const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true,
  authEndpoint: authEndpoint,
  auth: {
    headers: {
      Authorization: `Bearer ${token}`,
    }
  }
});

export default pusher;
