const formatMessages = (messages) => {
  if (messages && typeof messages === 'string') {
    return [messages];
  }

  const formattedMessages = [];
  for (const key in messages) {
    formattedMessages.push(Array.isArray(messages[key]) ? messages[key][0] : messages[0]);
  }
  return formattedMessages;
};

const formatDataToSelect = (data, value = 'id', label = 'name') => {
  const formattedData = [];
  data.forEach((item) => {
    formattedData.push({ label: item[label], value: item[value] });
  });
  return formattedData;
};

const formatTimestampToDate = (timestamp, dateFormat = 'YYYY-MM-DD') => {
  const date = new Date(timestamp * 1000);
  const year = date.getFullYear();
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const day = date.getDate().toString().padStart(2, '0');

  // Thực hiện định dạng ngày dựa trên dateFormat
  let formattedDate = dateFormat.replace('YYYY', year);
  formattedDate = formattedDate.replace('MM', month);
  formattedDate = formattedDate.replace('DD', day);

  return formattedDate;
};

function formatBytesToKBMB(bytes) {
  if (bytes < 1000) {
    return `${bytes} bytes`;
  } else if (bytes < 1000000) {
    const kb = (bytes / 1000).toFixed(0);
    return `${kb} KB`;
  } else {
    const mb = (bytes / 1000000).toFixed(0);
    return `${mb} MB`;
  }
}

export { formatMessages, formatDataToSelect, formatTimestampToDate, formatBytesToKBMB };
