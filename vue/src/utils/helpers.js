const debounce = (func, delay) => {
  let timerId;
  return (...args) => {
    clearTimeout(timerId);
    timerId = setTimeout(() => {
      func(...args);
    }, delay);
  };
};

const resizeImage = (image, width, height) => {
  if (!image) {
    return image;
  }
  const params = [];

  if (width) {
    params.push(`w=${width}`);
  }
  if (height) {
    params.push(`h=${height}`);
  }

  if (params.length > 0) {
    const separator = image.includes('?') ? '&' : '?';
    image += separator + params.join('&');
  }

  return image;
};

const getBase64 = (file) => {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });
};

const getFileNameFromUrl = (url) => {
  const parts = url.split('/');
  return parts[parts.length - 1];
};

const getFileFromFileList = (fileList) => {
  if (!fileList || fileList.length === 0) {
    return [];
  }
  const fileArr = fileList.map((file) => file.url);
  return JSON.stringify(fileArr);
};

const getImageToAnt = (images) => {
  if (!images) return [];

  // Kiểm tra nếu images là một chuỗi
  if (typeof images === 'string') {
    const fileName = getFileNameFromUrl(images);
    return [
      {
        uid: fileName,
        name: fileName,
        status: 'done',
        url: images
      }
    ];
  }

  // Kiểm tra nếu images là một mảng
  if (Array.isArray(images)) {
    return images.map((image) => ({
      uid: getFileNameFromUrl(image),
      name: getFileNameFromUrl(image),
      status: 'done',
      url: image
    }));
  }

  // Trường hợp còn lại, trả về mảng rỗng
  return [];
};

const isJSONString = (str) => {
  try {
    JSON.parse(str);
    return true;
  } catch (error) {
    return false;
  }
};

const cleanedData = (data) => {
  return Object.entries(data).filter(
    ([key, value]) => value != null && value != '' && value != undefined && value != 'null'
  );
};

export {
  debounce,
  resizeImage,
  getBase64,
  getFileNameFromUrl,
  getFileFromFileList,
  getImageToAnt,
  isJSONString,
  cleanedData
};
