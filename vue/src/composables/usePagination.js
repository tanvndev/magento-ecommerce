import { PAGESIZE } from '@/static/constants';
import { reactive, ref } from 'vue';

export default function usePagination() {
  const pagination = reactive({
    current: 1,
    pageSize: 10,
    total: 0,
    showSizeChanger: true,
    showQuickJumper: true,
    hideOnSinglePage: true,
    pageSizeOptions: PAGESIZE
  });
  const selectedRowKeys = ref([]);
  const selectedRows = ref([]);
  const onChangePagination = ref(null);

  const handleTableChange = (paginationTable, filters, sorter) => {
    pagination.current = paginationTable.current || 1;
    pagination.pageSize = paginationTable.pageSize || 10;
    onChangePagination.value = paginationTable.current;
  };

  const rowSelection = ref({
    checkStrictly: false,
    onChange: (selectedRowKeysRef, selectedRowsRef) => {
      selectedRowKeys.value = selectedRowKeysRef;
      selectedRows.value = selectedRowsRef;
    }
  });
  return {
    pagination,
    handleTableChange,
    onChangePagination,
    rowSelection,
    selectedRowKeys,
    selectedRows
  };
}
