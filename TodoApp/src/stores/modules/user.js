import axios from 'axios'

const state = {
    users: [],
    currentUser: {},
    todo: [],
    token: localStorage.getItem('access_token') || null,
    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + localStorage.getItem('access_token')
    }
}

const getters = {
    allUser: state => state.users,
    currentUser: state => state.currentUser,
    allTodo: state => state.todo,
    loggedIn(state){
        return state.token !== null
    }
}

const actions = {
    async fetchUser(context){
        context.state.setHeader()
        const response = await axios.post('/admin/users');
        context.commit('setUser', response.data)
    },
    async getCurrentUser(context){
        context.state.setHeader()
        const response = await axios.post('/auth/me');
        context.commit('setCurrentUser', response.data)
    },
    async fetchTodo(context){
        context.state.setHeader()
        const reponse = await axios.post('/auth/todo/get');
        context.commit('setTodo', reponse.data)
    },
    async deleteTodo(context, idTodo){
        context.state.setHeader()
        const response = await axios.post(`/auth/todo/delete/${idTodo}`)
        context.commit('removeTodo', idTodo)

    },
    async addTodo(context, todo){
        context.state.setHeader()
        const response = await axios.post('/auth/todo/create', {
            title: todo.title,
            description: todo.description
        });
        context.commit('addTodo', response.data)
    },

    async login(context, user){
        const response = await axios.post('/auth/login', {
                email: user.email,
                password: user.password
        })
        const token = response.data.access_token
        localStorage.setItem('access_token', token)
        axios.defaults.headers.common['Authorization'] = 'Bearer' + token
        context.commit('retrieveToken', token) 
    },

    async register(context, data){
        const response = await axios.post('register', {
            name: data.name,
            email: data.email,
            password: data.password
        })
        console.log(response)
    },

    async deleteUser(context, idUser){
        context.state.setHeader()
        const response = await axios.post(`/admin/delete/${idUser}`)
        context.commit('removeUser', idUser)
    },

    destroyToken(context){
        context.state.setHeader()
        if(context.getters.loggedIn){
            return new Promise((resolve, reject) => {
                axios.post('/auth/logout')
                .then(response => {
                    localStorage.removeItem('access_token')
                    context.commit('destroyToken')
                    resolve(response)
                    // console.log(token)
                    //console.log(response);
                })
                .catch(error => {
                    // console.log(error);
                    localStorage.removeItem('access_token')
                    context.commit('destroyToken')
                    reject(error)
                })
            })
        }
    }
}

const mutations = {
    setCurrentUser: (state, currentUser) => state.currentUser = currentUser,
    retrieveToken: (state, token) => state.token = token,
    destroyToken: (state) => {
        state.token = null,
        state.currentUser = null,
        state.users = []
    },
    setUser: (state, users) => (state.users = users),
    setTodo: (state, todo) => (state.todo=todo),
    addTodo: (state, todo) => state.todo.unshift(todo),
    removeTodo: (state, idTodo) => state.todo = state.todo.filter(todo=>todo.id!=idTodo),
    removeUser: (state, idUser) => state.users = state.users.filter(users=>users.id!=idUser)
}
export default{
    state,
    getters,
    actions,
    mutations

}