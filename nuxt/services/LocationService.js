import axios from '@/configs/axios';

class LocationService {
  async getProvinces() {
    try {
      const response = await axios.get('location/provinces');

      return {
        success: true,
        messages: response.messages,
        data: response.data
      };
    } catch (error) {
      let messages = error.response ? error.response.messages : 'Unexpected error occurred';
      return {
        success: false,
        messages: messages
      };
    }
  }
  async getLocations(payload) {
    try {
      const response = await axios.get('location/getLocation', {
        params: payload
      });

      return {
        success: true,
        messages: response.messages,
        data: response.data
      };
    } catch (error) {
      let messages = error.response ? error.response.messages : 'Unexpected error occurred';
      return {
        success: false,
        messages: messages
      };
    }
  }
}

export default new LocationService();
