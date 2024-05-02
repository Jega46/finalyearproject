
<template>
  <Head title="Employees" />
  <AuthenticatedLayout>
    <a-spin :spinning="loading" :delay="delayTime">
    </a-spin>
    <a-layout-content
      :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: 'calc(100vh - 115px)', textAlign: 'center' }">
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="formState" layout="inline" @finish="search">
          <a-form-item>
            <a-select v-model:value="formState.branch" placeholder="Select Branch" style="min-width:200px">
              <a-select-option :value="branch.id" v-for="branch in branches">{{ branch.branch_name }}</a-select-option>
            </a-select>
          </a-form-item>
          <a-form-item>
            <a-date-picker v-model:value="formState.date" format="DD-MM-YYYY" value-format="YYYY-MM-DD" />
          </a-form-item>
          <a-form-item>
            <a-input placeholder="Search Employees" v-model:value="formState.term">
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" html-type="submit">
              Search
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :row-key="employee => employee.employee_id" :data-source="employees"
          :pagination="pagination" :loading="loading" @change="handleTableChange">
          <template #bodyCell="{ column, text, record }">
            <template v-if="column.key === 'name'">
              <a-avatar style="color: #f56a00; background-color: #fde3cf">{{ text[0].toUpperCase() }}</a-avatar>
              &nbsp;
              {{ text }}
            </template>
            <template v-if="column.key === 'checkin'">
              <a-space direction="vertical">
                <a-time-picker :allowClear="false" format="hh:mm A" v-for="history in record.history"
                  placeholder="Check In" value-format="HH:mm:ss" v-model:value="history.checkin"
                  @change="updateAttendance(record)" />
              </a-space>
              <a-input v-model:value="history.id" :hidden="true" v-for="history in record.history" />
            </template>
            <template v-if="column.key === 'checkout'">
              <a-space direction="vertical">
                <div v-for="history in record.history">
                  <a-space direction="horizontal">
                    <a-time-picker :allowClear="false" format="hh:mm A" placeholder="Check Out" value-format="HH:mm:ss"
                      v-model:value="history.checkout" @change="updateAttendance(record)" />
                    <a v-if="history.checkout != ''" @click="deleteHistory(history.id)"><delete-outlined /></a>
                  </a-space>
                </div>
              </a-space>
            </template>
            <template v-if="column.key === 'overtime'">
              <a-space direction="vertical">
                <a-time-picker :allowClear="false" :disabled="true" format="HH:mm" placeholder="Over Time"
                  value-format="HH:mm" v-model:value="record.overtime" @change="updateOvertime(record)" />
              </a-space>
            </template>
            <template v-if="column.key === 'late'">
              <!-- <a-checkbox v-model:checked="record.late" :disabled="true" @change="updateLate(record)"></a-checkbox> -->
              <!-- <span style="color:red">{{ record.late == true ? 'Late' : '' }}</span> -->
              <a-table :columns="innerColumns" :data-source="innerData" :pagination="false">
                <template #bodyCell="{ column }">
                  <template v-if="column.key === 'state'">
                    <span>
                      <a-badge status="success" />
                      Finished
                    </span>
                  </template>
                  <template v-else-if="column.key === 'operation'">
                    <span class="table-operation">
                      <a>Pause</a>
                      <a>Stop</a>
                      <a-dropdown>
                        <template #overlay>
                          <a-menu>
                            <a-menu-item>Action 1</a-menu-item>
                            <a-menu-item>Action 2</a-menu-item>
                          </a-menu>
                        </template>
                        <a>
                          More
                          <down-outlined />
                        </a>
                      </a-dropdown>
                    </span>
                  </template>
                </template>
              </a-table>
            </template>
            <template v-if="column.key === 'notes'">
              <a-input-group compact>
                <a-input v-model:value="record.notes" style="width: calc(100% - 200px)" />
                <a-button type="primary" @click="updateAttendanceStatus(record)">Save</a-button>
              </a-input-group>
            </template>
            <template v-if="column.key === 'status'">
              <a-select v-model:value="record.status" @change="updateAttendanceStatus(record)">
                <a-select-option value="Present">Present</a-select-option>
                <a-select-option value="Absent">Absent</a-select-option>
                <a-select-option value="Paid Leave">Paid Leave</a-select-option>
                <a-select-option value="Unpaid Leave">Unpaid Leave</a-select-option>
                <a-select-option value="Week Off">Week Off</a-select-option>
              </a-select>
            </template>
          </template>
        </a-table>
      </a-space>
    </a-layout-content>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePagination } from 'vue-request';
import { computed, defineComponent } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import dayjs, { Dayjs } from 'dayjs';


import {
  DownloadOutlined,
  PlusCircleOutlined,
  MoreOutlined,
  DeleteOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
  {
    title: 'Name',
    key: 'name',
    dataIndex: 'name',
    sorter: true,
    width: '20%',
  },
  {
    title: 'Check In',
    key: 'checkin',
    width: '10%',
  },
  {
    title: 'Checkout',
    key: 'checkout',
    width: '10%',
  },
  {
    title: 'Overtime',
    key: 'overtime',
    width: '10%',
  },
  {
    title: 'Late',
    key: 'late',
    width: '10%',
  },
  {
    title: 'Notes',
    key: 'notes',
    width: '30%',
  },
  {
    title: 'Status',
    key: 'status',
    width: '20%',
  }
];
const innerColumns = [
  { title: 'Date', dataIndex: 'date', key: 'date' },
  { title: 'Name', dataIndex: 'name', key: 'name' },
  { title: 'Status', key: 'state' },
  { title: 'Upgrade Status', dataIndex: 'upgradeNum', key: 'upgradeNum' },
  {
    title: 'Action',
    dataIndex: 'operation',
    key: 'operation',
  },
];




export default ({
  components: { AuthenticatedLayout, DownloadOutlined, PlusCircleOutlined, MoreOutlined, DeleteOutlined, Head, Link },
  props: {
    date: String,
    employees: Object,
    branches: Object,
    pagination: Object,
    errors: Object,
  },
  setup(props) {
    return {
      columns,
    };
  },
  data(props) {
    const loading = false;
    const delayTime = 1500;
    const formState = useForm({
      term: '',
      date: props.date,
      branch: null
    });
    
    const innerDataItem = [];
    for (let i = 0; i < 3; ++i) {
      innerDataItem.push({
        key: i,
        date: '2014-12-24 23:12:00',
        name: `This is production name ${i + 1}`,
        upgradeNum: 'Upgraded: 56',
      });
    }

    return {
      page: 1,
      pageSize: 50,
      loading,
      delayTime,
      formState,
      innerColumns,
      innerDataItem
    };
  },
  methods: {
    search() {
      this.$inertia.get("/attendance", { s: this.formState.term, date: this.formState.date, branch: this.formState.branch, pageSize: this.pageSize }, { preserveState: true });
    },
    handleTableChange(val) {
      this.page = val.current;
      this.pageSize = val.pageSize;
      console.log(val);
      this.$inertia.get(
        "/attendance",
        { s: this.formState.term, date: this.formState.date, branch: this.formState.branch, page: val.current, pageSize: val.pageSize },
        { preserveState: true }
      );
    },
    updateAttendance(record) {
      this.loading = true;
      axios
        .post(route("attendance.updateattendance"), { ...record, ...{ date: this.formState.date } })
        .then((response) => {
          console.log(response);
          this.$inertia.get("/attendance", { s: this.formState.term, date: this.formState.date, branch: this.formState.branch, page: this.page, pageSize: this.pageSize }, { preserveState: true });
        })
        .finally(() => {
          this.loading = false;
        });
    },
    updateAttendanceStatus(record) {
      this.loading = true;
      axios
        .post(route("attendance.updateatt_statusnotes"), { ...record, ...{ date: this.formState.date } })
        .then((response) => {
          console.log(response);
          this.$inertia.get("/attendance", { s: this.formState.term, date: this.formState.date, branch: this.formState.branch, page: this.page, pageSize: this.pageSize }, { preserveState: true });
        })
        .finally(() => {
          this.loading = false;
        });
    },
    updateOvertime(record) {
      router.post(route("attendance.update_overtime"), { ...record, ...{ date: this.formState.date } }, {
        preserveState: true,
        onStart: visit => { this.loading = true; },
        onSuccess: page => { },
        onError: errors => { },
        onFinish: visit => {
          this.loading = false;
        },
      })
    },
    updateLate(record) {
      router.post(route("attendance.update_late"), { ...record, ...{ date: this.formState.date } }, {
        preserveState: true,
        onStart: visit => { this.loading = true; },
        onSuccess: page => { },
        onError: errors => { },
        onFinish: visit => {
          this.loading = false;
        },
      })
    },
    deleteHistory(id) {
      router.post(route("attendance.remove_attendance_history", id), {}, {
        onStart: visit => { this.loading = true; },
        onSuccess: page => {
        },
        onError: errors => { alert("dsfsd") },
        onFinish: visit => {
          this.loading = false;
        },
      })
    }

  }
});
</script>