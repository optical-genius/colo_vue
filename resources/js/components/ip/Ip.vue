<template>
    <div>
        <h4 class="text-center font-weight-bold">Colobog component</h4>
        Память: {{ips['memorylim']}}<br>
        Время выполнения скрипта: {{ips['start']}}
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">IP</th>
                <th scope="col">Host</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="ip in ips['vueRecordArray']">
                <td>
                    <input type="text" :value="ip['0'].ip_name"><br>
                    id: {{ip['0'].id}}
                </td>
                <td>
                    <div v-for="host in ip['1']" style="margin-bottom: 0px">
                        <input type="text" :value=" host.host_name ">
                    </div>
                </td>
                <td>
                    <button class="btn btn-danger" @click="deleteIp(ip)"><i style="color:white" class="fa fa-trash"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "Ips",
        mounted() {
            this.$store.dispatch('fetchIps')
        },
        methods: {
            deleteIp(ip) {
                this.$store.dispatch('deleteIp',ip['0'])
            }
        },
        computed: {
            ...mapGetters([
                'ips'
            ])
        }
    }
</script>

<style scoped>

</style>
