import axios from 'axios'
import Cookies from 'js-cookie'

const state ={
    todos: [],
    token: Cookies.get('access_token') || null,
    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + Cookies.get('access_token')
    }
}

const getters = {
    allTodo: (state) => state.todos,
}

const actions = {
    async fetchTodo(context){
        context.state.setHeader()
        const getTodoApi = await axios.post('/auth/todo/get')
        context.commit('SET_TODO', getTodoApi.data)
    },
    async deleteTodo(context, idTodo){
        context.state.setHeader()
        const deleteTodoApi = await axios.post(`/auth/todo/delete/${idTodo}`)
        context.commit('DELETE_TODO', idTodo)
    },
    async addTodo(context, todo){
        context.state.setHeader()
        const addTodoApi = await axios.post('/auth/todo/create', {
            title: todo.title,
            description: todo.description
        });
        context.commit('ADD_TODO', addTodoApi.data)
    }

}

const mutations = {
    SET_TODO: (state, todos) => (state.todos = todos),
    DELETE_TODO: (state, idTodo) => state.todos = state.todos.filter(todos=>todos.id!=idTodo),
    ADD_TODO: (state, todo) => state.todos.unshift(todo)
}

export default{
    state,
    getters,
    actions,
    mutations
}