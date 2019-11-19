let mutations = {
    CREATE_POST(state, post) {
        state.posts.unshift(post)
    },
    FETCH_POSTS(state, posts) {
        return state.posts = posts
    },
    FETCH_IPS(state, ips) {
        return state.ips = ips
    },
    DELETE_POST(state, post) {
        let index = state.posts.findIndex(item => item.id === post.id)
        state.posts.splice(index, 1)
    },
    DELETE_IP(state, ip) {
        console.log(ip.id);
        let index = state.ips['vueRecordArray'].findIndex(item => item.id === ip.id)
        state.ips['vueRecordArray'].splice(index, 1)
    }
}
export default mutations
