import VuetableFieldHandle from 'vuetable-2/src/components/VuetableFieldHandle.vue'

export default [
    {
        name: 'id',
        title: 'ID',
    },
    {
        name: 'name',
        title: 'Name',
    },
    {
        name: 'phone',
        title: 'Phone',
    },
    {
        name: 'gender',
        formatter: (value) => {
            return value === 0 ? 'Male' : 'Female'
        }
    },
    {
        name: 'datetime',
        title: 'Callback Time',
        sortField: 'datetime'
    },
    {
        name: 'created_at',
        title: 'Created at',
        sortField: 'created_at'
    },
    'actions'
]
