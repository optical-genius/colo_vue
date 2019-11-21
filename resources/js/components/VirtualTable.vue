<template>
    <vue-virtual-table
        :config="tableConfig"
        :data="tableData"
        :height="800"
        :itemHeight="55"
        :minWidth="1000"
        :selectable="true"
        :enableExport="true"
        v-on:changeSelection="handleSelectionChange"
        :language="tableAttribute.language"
    >
        <template slot-scope="scope" slot="actionCommon">
            <button @click="edit(scope.index, scope.row)">Edit</button>
            <button @click="del(scope.index, scope.row)">Delete</button>
        </template>
    </vue-virtual-table>
</template>

<script>
    import vuevirtualtable from 'vue-virtual-table'
    export default {
        components: {
            vuevirtualtable
        },
        props: {
            records: this.records,
        },
        data(){
            return{
            tableConfig: [
                { prop: '_index', name: '#', width: 80 },
                {
                    prop: 'ip_name',
                    name: 'IP',
                    searchable: true,
                    sortable: true,
                    summary: 'COUNT'
                },
                { prop: 'host', name: 'host', searchable: true },
                // { prop: 'city', name: 'City', filterable: true },
                { prop: '_action', name: 'Action', actionName: 'actionCommon' }
            ],
            tableData: this.records,
            tableAttribute: {
                height: 650,
                itemHeight: 42,
                minWidth: 1000,
                selectable: true,
                enableExport: true,
                bordered: false,
                hoverHighlight: true,
                language: "en"
            },
            }
        },
        mounted: function() {
            console.log(this.that);
        },
        methods: {
            handleSelectionChange(rows) {
                console.log(rows)
            },
            edit(index, row) {
                console.log(index)
            },
            del(index, row) {
                console.log(index)
            }
        }
    }
</script>
