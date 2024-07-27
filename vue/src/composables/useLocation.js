import { LocationService } from '@/services';
import { formatDataToSelect } from '@/utils/format';
import { ref } from 'vue';

export default function useLocation() {
  const provinces = ref(null);
  const districts = ref(null);
  const wards = ref(null);

  const getProvinces = async () => {
    const response = await LocationService.getProvinces();
    const responseFormat = formatDataToSelect(response.data, 'code', 'name');
    provinces.value = responseFormat;
    return responseFormat;
  };
  const getLocations = async (target, location_id) => {
    const response = await LocationService.getLocations({ target, location_id });
    const responseFormat = formatDataToSelect(response.data[target], 'code', 'name');

    if (target === 'districts') {
      districts.value = responseFormat;
    } else if (target === 'wards') {
      wards.value = responseFormat;
    }
  };

  return { getProvinces, getLocations, provinces, districts, wards };
}
