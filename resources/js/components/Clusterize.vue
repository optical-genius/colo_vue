<template>
    <RecycleScroller
        page-mode
        class="scroller"
        :items="records"
        :item-size="20"
        key-field="id"
        v-slot="{ item }"
    >



        <div class="user">
            <input type="text" :value="item.ip_name"> : {{ item.id }}
        </div>

    </RecycleScroller>
</template>


<script>
    export default {
        props: {
            records: this.records,
        },
    }
</script>

<style scoped>
    .vue-recycle-scroller {
        position: relative
    }

    .vue-recycle-scroller.direction-vertical:not(.page-mode) {
        overflow-y: auto
    }

    .vue-recycle-scroller.direction-horizontal:not(.page-mode) {
        overflow-x: auto
    }


    .scroller {
        height: 100%;
    }

    .user {
        height: 20px;
        padding: 0 12px;
        display: flex;
        align-items: center;
    }
</style>
