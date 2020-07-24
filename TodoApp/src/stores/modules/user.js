import axios from 'axios'

const state = {
    users: [],
    token: localStorage.getItem('access_token') || null,
}

const getters = {
    allUsers: state => state.users,
    loggedIn(state){
        return state.token !== null
    }
}

const actions = {
    
    async login({state, commit}, user){
        const response = await axios
            .post('/login', {
                email: user.email,
                password: user.password
            })
            .then(response => {
                if (response.data.access_token){
                    localStorage.setItem(
                        'userToken', response.data.access_token
                    )
                    window.location.replace('/')
                }
            })
        commit('login', response.data)
    },

    async register(context, data){
        return new Promise((resolve, reject) => {
            axios.post('/register', {
                name: data.name,
                email: data.email,
                password: data.password
            })
            .then(response => {
                resolve(response)
            })
            .catch(error => {
                reject(error)
            })
        })
    },

    retrieveToken(context, credentials){
        return new Promise((resolve, reject) => {
            axios.post('/login', {
                email: credentials.email,
                password: credentials.password
            })
            .then(response => {
                const token = response.data.access_token
                localStorage.setItem('access_token', token)
                context.commit('retrieveToken', token)
                resolve(response)
                // console.log(token)
                //console.log(response);
            })
            .catch(error => {
                console.log(error);
                reject(error)
            })
        })
    },
    destroyToken(context){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token
        if(context.getters.loggedIn){
            return new Promise((resolve, reject) => {
                axios.post('/logout')
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
    newUser: (state, user) => state.users.unshift(user),
    retrieveToken: (state, token) => state.token = token,
    destroyToken: (state) => state.token = null,
}
export default{


    state,
    getters,
    actions,
    mutations

}