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
        data: () => ({
            items: this.records,
            tableConfig: [
                { prop: '_index', name: '#', width: 80 },
                {
                    prop: 'ip_name',
                    name: 'IP',
                    searchable: true,
                    sortable: true,
                    summary: 'COUNT'
                },
                // { prop: 'age', name: 'Age', numberFilter: true },
                // { prop: 'city', name: 'City', filterable: true },
                { prop: '_action', name: 'Action', actionName: 'actionCommon' }
            ],
            tableData: [
                {"ip_name":"151.85.154.162","id":4185},{"ip_name":"248.221.17.242","id":4365},{"ip_name":"79.209.206.124","id":4390},{"ip_name":"120.14.247.92","id":4391},{"ip_name":"192.168.0.2","id":4405},{"ip_name":"200.77.6.63","id":4407},{"ip_name":"137.101.50.157","id":4408},{"ip_name":"93.101.24.60","id":4409},{"ip_name":"25.213.45.239","id":4410},{"ip_name":"192.168.0.3","id":4421},{"ip_name":"13.164.161.212","id":4422},{"ip_name":"30.83.243.28","id":4442},{"ip_name":"199.48.227.219","id":4443},{"ip_name":"234.255.197.248","id":4444},{"ip_name":"46.193.149.16","id":4445},{"ip_name":"20.20.253.93","id":4446},{"ip_name":"166.115.212.51","id":4447},{"ip_name":"88.29.155.199","id":4448},{"ip_name":"149.207.177.234","id":4449},{"ip_name":"14.126.79.224","id":4450},{"ip_name":"72.182.170.220","id":4495},{"ip_name":"63.122.0.222","id":4496},{"ip_name":"100.2.200.30","id":4497},{"ip_name":"112.93.143.237","id":4498},{"ip_name":"68.61.23.84","id":4499},{"ip_name":"157.1.219.128","id":4500},{"ip_name":"51.104.55.188","id":4501},{"ip_name":"13.2.103.213","id":4502},{"ip_name":"237.188.142.113","id":4503},{"ip_name":"64.122.83.32","id":4504},{"ip_name":"174.218.216.116","id":4505},{"ip_name":"73.231.156.116","id":4506},{"ip_name":"59.234.118.46","id":4507},{"ip_name":"183.241.127.149","id":4508},{"ip_name":"140.135.186.80","id":4509},{"ip_name":"53.222.50.100","id":4510},{"ip_name":"73.150.134.250","id":4511},{"ip_name":"159.245.66.231","id":4512},{"ip_name":"182.253.120.114","id":4513},{"ip_name":"190.105.179.245","id":4514},{"ip_name":"201.155.107.29","id":4515},{"ip_name":"230.191.43.129","id":4516},{"ip_name":"173.162.243.13","id":4517},{"ip_name":"235.200.88.43","id":4518},{"ip_name":"192.196.172.145","id":4519},{"ip_name":"221.62.13.212","id":4520},{"ip_name":"168.99.212.183","id":4521},{"ip_name":"197.219.86.115","id":4522},{"ip_name":"78.168.11.132","id":4523},{"ip_name":"86.170.204.173","id":4524},{"ip_name":"205.244.148.234","id":4525},{"ip_name":"164.118.110.81","id":4526},{"ip_name":"104.132.118.208","id":4527},{"ip_name":"104.24.131.34","id":4528},{"ip_name":"173.181.158.239","id":4529},{"ip_name":"57.237.104.179","id":4530},{"ip_name":"9.177.160.152","id":4531},{"ip_name":"187.31.24.216","id":4542},{"ip_name":"133.76.65.130","id":4543},{"ip_name":"3.46.4.88","id":4544},{"ip_name":"178.13.33.116","id":4545},{"ip_name":"112.36.220.235","id":4546},{"ip_name":"20.84.93.197","id":4547},{"ip_name":"136.231.222.89","id":4548},{"ip_name":"35.61.32.210","id":4549},{"ip_name":"31.45.107.243","id":4550},{"ip_name":"5.178.214.64","id":4551},{"ip_name":"127.161.94.13","id":4552},{"ip_name":"142.111.222.213","id":4553},{"ip_name":"50.139.20.134","id":4554},{"ip_name":"95.176.114.23","id":4555},{"ip_name":"145.41.254.39","id":4556},{"ip_name":"251.100.210.103","id":4557},{"ip_name":"209.158.82.221","id":4558},{"ip_name":"230.172.75.230","id":4559},{"ip_name":"127.132.59.139","id":4560},{"ip_name":"193.36.198.211","id":4561},{"ip_name":"196.106.7.205","id":4562},{"ip_name":"103.90.187.218","id":4563},{"ip_name":"56.150.189.83","id":4564},{"ip_name":"186.41.134.35","id":4565},{"ip_name":"100.247.32.108","id":4566},{"ip_name":"112.172.114.157","id":4567},{"ip_name":"254.112.219.140","id":4568},{"ip_name":"110.171.71.77","id":4569},{"ip_name":"223.63.123.193","id":4570},{"ip_name":"140.78.205.213","id":4571},{"ip_name":"247.48.78.134","id":4572},{"ip_name":"186.38.173.12","id":4573},{"ip_name":"143.212.195.154","id":4574},{"ip_name":"103.13.177.141","id":4575},{"ip_name":"93.255.13.227","id":4576},{"ip_name":"55.165.175.222","id":4577},{"ip_name":"185.89.137.105","id":4578},{"ip_name":"173.236.47.18","id":4579},{"ip_name":"182.102.191.130","id":4580},{"ip_name":"230.67.83.52","id":4581},{"ip_name":"253.69.168.32","id":4582},{"ip_name":"242.130.228.13","id":4583},{"ip_name":"66.169.47.126","id":4584}

            ],
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

        }),
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
