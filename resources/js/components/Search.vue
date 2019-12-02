<template>
    <div id="searchcomponent">
        <div class="row">
            <div class="col-3">
                <input type="text" v-model="ipname" name="ip_name" id="ip_name" placeholder="IP addr">
            </div>
            <div class="col-3">
                <input type="text" v-model="hostname" name="host_name" id="host_name" placeholder="Host">
            </div>
            <div class="col-3">
                <input type="text" v-model="portname" name="port_name" id="port_name" placeholder="Port">
            </div>
            <div class="col-3">
                <button v-on:click="searchGet">Поиск</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { bus } from '../app.js';
    export default {
        name: 'searchcomponent',
        data: function() {
            return {
                ipname: '',
                hostname: '',
                portname: '',
                output: '',
                response: ''
            };
        },
        methods: {
            searchGet: function(event) {

                let params = {}
                params['ip_name'] = this.ipname;
                params['host_name'] = this.hostname;
                params['port_name'] = this.portname;

                axios
                    .get('/api/tests', {params: params})
                    .then(response => (this.output = response.data))
                    .catch(function (error) {
                        console.log(error);
                    });
                bus.$emit('mega-event', this.output.vueRecordArray);


             }
        }

    }
</script>

<style scoped>

</style>
