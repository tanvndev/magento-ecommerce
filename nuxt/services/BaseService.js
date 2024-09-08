import axios from '@/configs/axios';

class BaseService {
  async changeStatus(payload) {
    try {
      const response = await axios.put('/dashboard/changeStatus', payload);

      return {
        success: true,
        messages: response.messages
      };
    } catch (error) {
      let messages = error.response
        ? error.response.messages
        : 'Có lỗi từ máy chủ vui lòng liên hệ quản trị viên để được hỗ trợ.';
      return {
        success: false,
        messages: messages
      };
    }
  }
  async changeStatusAll(payload) {
    try {
      const response = await axios.put('/dashboard/changeStatusMultiple', payload);

      return {
        success: true,
        messages: response.messages
      };
    } catch (error) {
      let messages = error.response
        ? error.response.messages
        : 'Có lỗi từ máy chủ vui lòng liên hệ quản trị viên để được hỗ trợ.';
      return {
        success: false,
        messages: messages
      };
    }
  }

  async getOne(endpoint, id) {
    try {
      const response = await axios.get(`${endpoint}/${id}`);

      return {
        success: true,
        messages: response.messages,
        data: response.data
      };
    } catch (error) {
      let messages = error.response
        ? error.response.messages
        : 'Có lỗi từ máy chủ vui lòng liên hệ quản trị viên để được hỗ trợ.';
      return {
        success: false,
        messages: messages
      };
    }
  }

  async getAll(endpoint, payload, ...filers) {
    try {
      const response = await axios.get(`${endpoint}`, {
        params: { ...payload, ...filers }
      });

      return {
        success: true,
        messages: response.messages,
        data: response.data
      };
    } catch (error) {
      let messages = error.response
        ? error.response.data.messages
        : 'Có lỗi từ máy chủ vui lòng liên hệ quản trị viên để được hỗ trợ.';
      return {
        success: false,
        messages: messages
      };
    }
  }
  async create(endpoint, payload) {
    try {
      const response = await axios.post(`${endpoint}`, payload, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });

      return {
        data: response.data ?? [],
        success: true,
        messages: response.messages
      };
    } catch (error) {
      let messages = error.response
        ? error.response.data.messages
        : 'Có lỗi từ máy chủ vui lòng liên hệ quản trị viên để được hỗ trợ.';
      return {
        success: false,
        messages: messages
      };
    }
  }

  async update(endpoint, id, payload) {
    try {
      const endpointUpdate =
        id == null ? `${endpoint}?_method=PUT` : `${endpoint}/${id}?_method=PUT`;

      const response = await axios.post(endpointUpdate, payload, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });

      return {
        success: true,
        messages: response.messages
      };
    } catch (error) {
      let messages = error.response
        ? error.response.data.messages
        : 'Có lỗi từ máy chủ vui lòng liên hệ quản trị viên để được hỗ trợ.';
      return {
        success: false,
        messages: messages
      };
    }
  }
  async deleteOne(endpoint, id, payload = null) {
    try {
      const response = await axios.delete(`${endpoint}/${id}`, {
        params: payload
      });

      return {
        data: response.data ?? [],
        success: true,
        messages: response.messages
      };
    } catch (error) {
      let messages = error.response
        ? error.response.data.messages
        : 'Có lỗi từ máy chủ vui lòng liên hệ quản trị viên để được hỗ trợ.';
      return {
        success: false,
        messages: messages
      };
    }
  }

  async deleteMultiple(payload) {
    try {
      const response = await axios.delete('/dashboard/deleteMultiple', { data: payload });
      return {
        success: true,
        messages: response.messages
      };
    } catch (error) {
      let messages = error.response
        ? error.response.data.messages
        : 'Có lỗi từ máy chủ vui lòng liên hệ quản trị viên để được hỗ trợ.';
      return {
        success: false,
        messages: messages
      };
    }
  }
}

export default new BaseService();
