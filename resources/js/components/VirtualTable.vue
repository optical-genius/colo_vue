<template>
    <div>
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
                <button @click="show(scope.index, scope.row)">Edit</button>
                <button @click="del(scope.index, scope.row)">Delete</button>
            </template>

            <template slot-scope="scope" slot="hosts">
                <div v-for="(host, index) in scope.row.host" style="display: block; float: left; width: 100%;" v-on:click.right="show(scope.index, scope.row)" @contextmenu.prevent>
                    <div :id="index" v-bind:key="index">{{host}}</div>
                </div>
            </template>

            <template slot-scope="scope" slot="ports">
                <div v-for="port in scope.row.port" v-on:click.right="show(scope.index, scope.row)" @contextmenu.prevent>
                    <div>{{port}},</div>
                </div>
            </template>
        </vue-virtual-table>

        <!-- MODAL COMPONENT -->

        <modal :draggable="true" :resizable="true" :width="1200" :height="800" v-bind:popupdata="popupdata" name="colobog-popup">

            <div class="row" style="margin: 40px">
                <div>
                    <div class="col">
                        Изменить IP
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" :value="popupdata.ip_name" :id="popupdata.id">
                    </div>
                </div>
            </div>

            <div class="row" style="margin: 40px">
                <div v-for="(host, index) in popupdata.host">
                    <div class="col">
                        Изменить {{host}} : {{index}}
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" :value="host">
                        <a href="" style="position: absolute; display: block; right: 0; top: 0;" @click.prevent="hostDelete(index)">x</a>
                    </div>
                </div>
            </div>

            <div class="row" style="margin: 40px">
                <div>
                    <div class="col">
                        Добавить хост
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Имя хоста">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </div>
            </div>

            <div class="row" style="margin: 40px">
                <div v-for="(port, index) in popupdata.port">
                    <div class="col">
                       ID: {{index}} | Изменить {{port}} | <a href="">x</a>
                    </div>
                </div>
            </div>

            <div class="row" style="margin: 40px">
                <div>
                    <div class="col">
                        Добавить порт
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Имя порта">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </div>
            </div>

        </modal>

    </div>
</template>



<script>

    //Создаем шину для передачи данных между компонентами search и virtualtable
    import {bus} from '../app.js';

    import vuevirtualtable from 'vue-virtual-table';

    //Импорт компонента - модальные окна
    import VModal from 'vue-js-modal';
    Vue.use(VModal);

    export default {
        components: {
            vuevirtualtable,
            VModal
        },
        props: {
            records: this.records,
        },
        data() {
            return {
                //Переменная для попап окна
                popupdata: '',
                scopeindex: '',

                //Конфиг компонента vuevirtualtable
                tableConfig: [
                    {prop: '_index', name: '#', width: 80},
                    {
                        prop: 'ip_name',
                        name: 'IP',
                        searchable: true,
                        sortable: true,
                        summary: 'COUNT',
                        width: 130
                    },
                    {prop: '_action', name: 'HOST', actionName: 'hosts', width: 180},
                    {prop: '_action', name: 'PORT', actionName: 'ports', width: 200},
                    // { prop: 'host', name: 'HOST', searchable: true },
                    // { prop: 'port', name: 'PORT', filterable: true },
                    {prop: '_action', name: 'Action', actionName: 'actionCommon'},
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
        mounted: function () {
            bus.$on('mega-event', data => {
                this.tableData = data;
            });
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
            },
            hostDelete(index){
                let params = {}
                params['index'] = index;

                axios
                    .delete(`/api/hosts/${index}`)
                    .then(response => (console.log(response.data)))
                    .catch(function (error) {
                        console.log(error);
                    });

                //Удаляем хост из попапа
                this.$delete(this.popupdata.host, index);

                //Удаляем хост из глобальной таблицы
                this.$delete(this.tableData[this.scopeindex.toString()].host, index);

            },
            show (index, row) {
                this.popupdata = row;
                this.$modal.show('colobog-popup', {popupdata: 'popupdata'}, { draggable: true });
                this.scopeindex = index;
                console.log(index);
            },
            hide () {
                this.$modal.hide('colobog-popup');
            }
        }
    }
</script>
