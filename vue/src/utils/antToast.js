import { message, notification } from 'ant-design-vue';

export function useAntToast() {
  const showMessage = (type, content, duration = 4.5) => {
    const validMessageTypes = ['success', 'error', 'info', 'warning', 'loading'];
    if (validMessageTypes.includes(type)) {
      message[type](content, duration);
    } else {
      console.error(`Invalid message type: ${type}`);
    }
  };

  const showNotification = (type, title, description, duration = 4.5) => {
    const validNotificationTypes = ['success', 'error', 'info', 'warning'];
    if (validNotificationTypes.includes(type)) {
      notification[type]({
        message: title,
        description: description,
        duration: duration
      });
    } else {
      console.error(`Invalid notification type: ${type}`);
    }
  };

  return { showMessage, showNotification };
}
