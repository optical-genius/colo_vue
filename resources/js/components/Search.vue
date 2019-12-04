<template>
    <div id="searchcomponent">
        <div class="row" style="text-align: center">
            <div class="col-3">
                <!--                @focusin="focus(true)" @focusout="focus(false)"-->
                <input type="text" v-on:keyup.enter="searchGet" v-model="ipname" name="ip_name" id="ip_name"
                       placeholder="IP addr">
            </div>
            <div class="col-3">
                <input type="text" v-on:keyup.enter="searchGet" v-model="hostname" name="host_name" id="host_name"
                       placeholder="Host">
            </div>
            <div class="col-3">
                <input type="text" v-model="portname" name="port_name" id="port_name" placeholder="Port">
            </div>
            <div class="col-1">
                <button v-on:click="searchGet">Поиск</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {bus} from '../app.js';
    export default {
        name: 'searchcomponent',
        data: function () {
            return {
                ipname: '',
                hostname: '',
                portname: '',
                output: '',
                response: '',
                hasfocus: false,
            };
        },
        watch: {
            output: function (val, oldVal) {
                bus.$emit('mega-event', this.output.vueRecordArray);
            },
        },
        methods: {
            searchGet: function (event) {
                let params = {}
                params['ip_name'] = this.ipname;
                params['host_name'] = this.hostname;
                params['port_name'] = this.portname;

                axios
                    .get('/api/search', {params: params})
                    .then(response => (this.output = response.data))
                    .catch(function (error) {
                        console.log(error);
                    });


            },
            // focus (value) {
            //     this.hasfocus = value;
            //     if(this.hasfocus === false) {
            //         this.ipname = null;
            //         this.hostname = null;
            //     }
            // },
        }

    }
</script>

<style scoped>

</style>
