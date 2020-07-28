import axios from 'axios'

const state ={
    todos: [],
    token: localStorage.getItem('access_token') || null,

}

const getters = {
    allTodo: (state) => state.todos,
}

const actions = {
    async fetchTodo(context){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token
        const response = await axios.post('/auth.todo/get');
        context.commit('setTodo', response.data)
    }
}

const mutations = {
    setTodo: (state, todos) => (state.todos = todos),
}

export default{
    state,
    getters,
    actions,
    mutations
}