<template>
    <DynamicScroller
        :items="items"
        :min-item-size="24"
        class="scroller"
    >
        <template v-slot="{ item, index, active }">
            <DynamicScrollerItem
                :item="item"
                :active="active"
                :size-dependencies="[
          item.host,
        ]"
                :data-index="index"
            >


                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">IP</th>
                        <th scope="col">Host</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" :value="item.ip_name"><br>
                        </td>
                        <td>
                            <div v-for="host in item.host" style="margin-bottom: 0px">
                                <input type="text" :value=" host.host_name ">
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-danger" @click="deleteIp(ip)"><i style="color:white" class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </DynamicScrollerItem>
        </template>
    </DynamicScroller>
</template>




<!--<template>-->

<!--        <RecycleScroller-->
<!--            page-mode-->
<!--            class="scrollerrrrr"-->
<!--            :items="list"-->
<!--            :item-size="30"-->
<!--            key-field="id"-->
<!--            v-slot="{ item }"-->
<!--        >-->
<!--            <div class="user">{{ item.ip_name }}</div>-->

<!--        </RecycleScroller>-->

<!--</template>-->

<script>
    export default {
        name: "App",
        props: {
            records: this.records,
        },
        data() {
            return {
                items: this.records,
            };
        },
    };
</script>

<style>
    .scrollerrrrr {
        height: 100%;
    }

    .user {
        height: 32%;
        padding: 0 12px;
        display: flex;
        align-items: center;
        background-color: #c0c0c0;
    }
</style>
