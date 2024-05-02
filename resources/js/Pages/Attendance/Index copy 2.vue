
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
          <a-form-item>
            <a-button type="primary">
              Add Time Manually
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :row-key="record => record.employee_id" :data-source="employees"
          :pagination="pagination" :loading="loading" @change="handleTableChange">
          <template #bodyCell="{ column, text, record }">
            <template v-if="column.key === 'name'">
              <a-avatar style="color: #f56a00; background-color: #fde3cf">{{ text[0].toUpperCase() }}</a-avatar>
              &nbsp;
              {{ text }}
            </template>
            <template v-if="column.key === 'status'">
              <a-tag :color="statusColor[record.status]">{{ record.status }}</a-tag>
            </template>
            <template v-if="column.key === 'latestatus'">
              <a-tag v-if="record.status == 'Present'" :color="(record.late == true ? 'red' : 'green')">
                {{ (record.late == true) ? 'Late' : 'On Time' }}
              </a-tag>
            </template>
            <template v-if="column.key === 'autoaction'">
              <a-space direction="horizontal">
                <div v-if="record.history.length">
                  <a-button type="primary" @click="clockIn(record)"
                    v-if="record.history[record.history.length - 1].checkout != null">Clock In</a-button>
                  <a-button v-if="record.history[record.history.length - 1].checkout == null"
                    @click="clockOut(record)">Clock Out</a-button>
                  <a-dropdown v-if="record.history[record.history.length - 1].breakid == null">
                    <template #overlay>
                      <a-menu>
                        <a-menu-item v-for="brk in breaks" :key="brk.id" @click="addBreak(record, brk.id)">{{ brk.name
                        }}
                        </a-menu-item>
                      </a-menu>
                    </template>
                    <a-button>
                      Break
                      <DownOutlined />
                    </a-button>
                  </a-dropdown>
                  <a-button v-else @click="clockOut(record)">Close Break</a-button>
                </div>
                <div v-else>
                  <a-button type="primary" @click="clockIn(record)">Clock In</a-button>
                </div>
              </a-space>
            </template>
            <template v-if="column.key === 'manualaction'">
              <a-button type="default" danger @click="addmanualrows(record)">Add Attendance</a-button>
              <a-button type="primary" danger v-if="showmanualsave.includes(record.employee_id)"
                @click="savemanualdata(record)">Save Attendance</a-button>
            </template>
          </template>
          <template #expandedRowRender="{ record }" :style="'padding:10px'">
            <a-table class="table-sm" :pagination="false" :columns="innercolumns" :row-key="history => history.id"
              :data-source="record.history" :set="parentrecord = record">
              <template #bodyCell="{ column, text, record }">
                <template v-if="column.key === 'location'">
                  <a-select v-if="record.id == '' || editableData.includes(record.id)" v-model:value="record.branchid"
                    placeholder="Select Branch" style="min-width:200px">
                    <a-select-option :value="branch.id" v-for="branch in branches">
                      {{ branch.branch_name }}
                    </a-select-option>
                  </a-select>
                  <div v-else>
                    {{ record.branch.branch_name ?? '-' }}
                  </div>
                </template>
                <template v-if="column.key === 'in'">
                  <a-time-picker :allowClear="true" format="hh:mm A" placeholder="Check In" value-format="HH:mm:ss"
                    v-if="record.id == '' || editableData.includes(record.id)" v-model:value="record.checkin" />
                  <div v-else>
                    {{ moment(record.checkin, "HH:mm:ss").format('hh:mm A') }}
                  </div>
                </template>
                <template v-if="column.key === 'out'">
                  <a-time-picker :allowClear="true" format="hh:mm A" placeholder="Check Out" value-format="HH:mm:ss"
                    v-if="record.id == '' || editableData.includes(record.id)" v-model:value="record.checkout" />
                  <div v-else>
                    {{ (record.checkout != null) ? moment(record.checkout, "HH:mm:ss").format('hh:mm A') : '-' }}
                  </div>
                </template>
                <template v-if="column.key === 'break'">
                  <a-select :allowClear="true" v-model:value="record.breakid"
                    v-if="record.id == '' || editableData.includes(record.id)" :style="'width: 150px'">
                    <a-select-option v-for="brk in breaks" :value="brk.id">{{ brk.name }}</a-select-option>
                  </a-select>
                  <div v-else>
                    <a-tag color="blue" v-if="record.breakid != null">{{ record.break.name }}</a-tag>
                  </div>
                </template>
                <template v-if="column.key === 'notes'">
                  <a-input v-if="record.id == '' || editableData.includes(record.id)" v-model:value="record.notes"
                    style="width: 100%" />
                  <span v-else>{{ record.notes }}</span>
                </template>
                <template v-if="column.key === 'action'">
                  <a-space direction="horizontal" v-if="record.id != ''">
                    <div class="editable-row-operations">
                      <span v-if="record.id == '' || editableData.includes(record.id)">
                        <a-button type="primary" @click="savehistory(record)">Save</a-button>
                        <a-popconfirm title="Sure to cancel?" @confirm="cancel(record.id)">
                          <a-button type="default">Cancel</a-button>
                        </a-popconfirm>
                      </span>
                      <span v-else>
                        <a-button @click="edit(record.id)">
                          <template #icon>
                            <EditOutlined />
                          </template>
                        </a-button>
                      </span>
                    </div>
                    <a-popconfirm title="Sure to delete?" @confirm="deletehistory(record.id)">
                      <a-button>
                        <template #icon>
                          <DeleteOutlined />
                        </template>
                      </a-button>
                    </a-popconfirm>
                  </a-space>
                  <a-space v-else>
                    <a-popconfirm title="Sure to delete?" @confirm="deletemanualrow(parentrecord, record)">
                      <a-button>
                        <template #icon>
                          <DeleteOutlined />
                        </template>
                      </a-button>
                    </a-popconfirm>
                  </a-space>
                </template>
              </template>
            </a-table>
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
import { message } from 'ant-design-vue';
import moment from 'moment';


import {
  DownloadOutlined,
  PlusCircleOutlined,
  MoreOutlined,
  DeleteOutlined,
  EditOutlined
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
    title: 'Attendance Status',
    key: 'status',
    width: '20%',
  },
  {
    title: 'Late Status',
    key: 'latestatus',
    width: '10%',
  },
  // {
  //   title: 'Auto Action',
  //   key: 'autoaction',
  //   width: '30%',
  // },
  {
    title: 'Action',
    key: 'manualaction',
    width: '30%',
  }
];

const innercolumns = [
  {
    title: 'Location',
    key: 'location',
    dataIndex: '',
  },
  {
    title: 'In',
    key: 'in',
    dataIndex: 'checkin',
  },
  {
    title: 'Out',
    key: 'out',
    dataIndex: 'checkout',
  },
  {
    title: 'Break',
    key: 'break',
    dataIndex: '',
  },
  {
    title: 'Notes',
    key: 'notes',
    dataIndex: '',
  },
  {
    title: 'Action',
    key: 'action',
    dataIndex: '',
  }
];

export default ({
  components: {
    AuthenticatedLayout,
    DownloadOutlined,
    PlusCircleOutlined,
    MoreOutlined,
    DeleteOutlined,
    Head,
    Link,
    EditOutlined,

  },
  props: {
    date: String,
    employees: Object,
    breaks: Object,
    branches: Object,
    pagination: Object,
    errors: Object,
  },
  setup(props) {
    return {
      columns,
      innercolumns
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
    const statusColor = {
      'Present': 'green', 'Absent': 'red', 'Paid Leave': 'blue', 'Unpaid Leave': 'orange', 'Day Off': 'purple'
    };
    return {
      moment,
      editableData: [],
      statusColor,
      page: 1,
      pageSize: 50,
      loading,
      delayTime,
      formState,
      showmanualsave: [],
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
    clockIn(record) {
      this.loading = true;
      axios
        .post(route("attendance.clockin"), { ...record, ...{ date: this.formState.date } })
        .then((response) => {
          console.log(response);
          this.$inertia.get("/attendance", { s: this.formState.term, date: this.formState.date, branch: this.formState.branch, page: this.page, pageSize: this.pageSize }, { preserveState: true });
        })
        .finally(() => {
          this.loading = false;
        });
    },
    clockOut(record) {
      this.loading = true;
      axios
        .post(route("attendance.clockout"), { ...record, ...{ date: this.formState.date } })
        .then((response) => {
          console.log(response);
          this.$inertia.get("/attendance", { s: this.formState.term, date: this.formState.date, branch: this.formState.branch, page: this.page, pageSize: this.pageSize }, { preserveState: true });
        })
        .finally(() => {
          this.loading = false;
        });
    },
    addBreak(record, breakid) {
      this.loading = true;
      axios
        .post(route("attendance.addbreak"), { ...record, ...{ date: this.formState.date, breakid: breakid } })
        .then((response) => {
          console.log(response);
          this.$inertia.get("/attendance", { s: this.formState.term, date: this.formState.date, branch: this.formState.branch, page: this.page, pageSize: this.pageSize }, { preserveState: true });
        })
        .finally(() => {
          this.loading = false;
        });
    },
    edit(key) {
      this.editableData.push(key);
    },
    cancel(key) {
      const index = this.editableData.indexOf(key);
      if (index > -1) {
        this.editableData.splice(index, 1);
      }
    },
    savehistory(history) {
      var url = route("attendance.updatehistory");
      router.post(url, history, {
        onStart: visit => { this.loading = true; },
        onSuccess: page => {
          this.cancel(history.id);
        },
        onError: errors => {
          this.loading = false;
          Object.keys(errors).forEach(function (key) {
            message.error(errors[key]);
          });
        },
        onFinish: visit => {
          this.loading = false;
        },
      })
    },
    deletehistory(id) {
      router.post(route("attendance.deletehistory", id), {}, {
        onStart: visit => { this.loading = true; },
        onSuccess: page => {
        },
        onFinish: visit => {
          this.loading = false;
        },
      })
    },
    addmanualrows(record) {
      record.history.push({
        employee_id: record.employee_id,
        attdate: record.attdate,
        id: '',
        checkin: '',
        checkout: '',
        breakid: '',
        notes: '',
      });
      this.showmanualsave.push(record.employee_id);
      
    },
    savemanualdata(record) {
      var url = route("attendance.addmultiplehistory");
      router.post(url, record, {
        onStart: visit => { this.loading = true; },
        onSuccess: page => {
        },
        onError: errors => {
          this.loading = false;
          Object.keys(errors).forEach(function (key) {
            message.error(errors[key]);
          });
        },
        onFinish: visit => {
          this.loading = false;
        },
      })
    },
    deletemanualrow(parentrecord, record) {
      const index1 = this.employees.indexOf(parentrecord);
      if (index1 > -1) {
        const index = this.employees[index1].history.indexOf(record);
        this.employees[index1].history.splice(index, 1);
      }
    }
  }
});
</script>