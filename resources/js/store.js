export default{
    state:{
        lastSearch:{
            from: null,
            to:null
        }
    },
    mutations: {
        changeSearch(state, payload){
            state.lastSearch = payload

        }
    }
}