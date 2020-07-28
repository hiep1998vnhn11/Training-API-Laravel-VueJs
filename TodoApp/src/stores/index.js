import Vue from 'vue'
import Vuex from 'vuex'
import User from './modules/user'
import Todo from './modules/todo'
import Auth from './modules/auth'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        user: User,
        todo: Todo,
        auth: Auth
    }
})