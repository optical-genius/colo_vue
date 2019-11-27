<template>
    <vue-virtual-table
        :config="tableConfig"
        :data="tableData"
        :height="700"
        :itemHeight="120"
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

        <template slot-scope="scope" slot="hosts">
            <div v-for="host in scope.row.host" style="display: block; float: left; width: 100%;">
                <div>{{host.host_name}}</div>
            </div>
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
                    summary: 'COUNT',
                    width: 130
                },
                {prop: '_action', name: 'HOST', actionName: 'hosts', width: 120},
                // { prop: 'host', name: 'HOST', searchable: true },
                { prop: 'port', name: 'PORT', filterable: true },
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
            // let arr = [];
            //
            // this.records.forEach((value, index) => {
            //     arr.push(value);
            //     console.log(value.host);
            // });
        },
        methods: {
            handleSelectionChange(rows) {
                console.log(rows)
            },
            edit(index, row) {
                console.log(row)
            },
            del(index, row) {
                console.log(index)
            }
        }
    }
</script>
