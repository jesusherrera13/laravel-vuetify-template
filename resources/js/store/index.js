import { createStore } from "vuex";
import axiosClient from "../axios";
import router from "../router";


const store = createStore({
    state: {
        user: {
            data: JSON.parse(sessionStorage.getItem(`${import.meta.env.VITE_APP_NAME}_user_data`)),
            token: sessionStorage.getItem(`${import.meta.env.VITE_APP_NAME}_token`)
        },
        notificacions: {

        },
        
    },
    getters: {},
    actions: {
        login({ commit }, user) {
            return axiosClient.post('/login', user)
                .then(({ data }) => {
                    commit('setUser', data);
                    return data;
                });
        },
        logout({ commit }) {
            return axiosClient.post('/logout')
                .then(({ data }) => {
                    commit('logout');
                    return data;
                });
        },
        register({ commit }, user) {
            return axiosClient.post('/register', user)
                .then(({ data }) => {
                    commit('toLogin', data);
                    return data;
                });
        },
        systemModules({ commit }, user) {
            return axiosClient.post('/system-modules', user.data)
                .then(({ data }) => {
                    commit('setModules', data);
                })
                .catch(function (error) {

                    if (error.response && error.response.data.message == 'Unauthenticated.') {
                        commit('logout');
                    }
                })
                .then(function () {


                });
        }
    },
    mutations: {
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.user;
            sessionStorage.setItem(`${import.meta.env.VITE_APP_NAME}_user_data`, JSON.stringify(userData.user));
            sessionStorage.setItem(`${import.meta.env.VITE_APP_NAME}_token`, userData.token);
        },
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem(`${import.meta.env.VITE_APP_NAME}_user_data`);
            sessionStorage.removeItem(`${import.meta.env.VITE_APP_NAME}_token`);

            router.push({ name: 'Login' });
        },
        toLogin: (state) => {
            router.push({ name: 'Login' });
        },
        setModules: (state, modules) => {
            modules.sort((a, b) => {
                if (a.name < b.name) return -1;
            });

            for (var i in modules) {
                if (modules[i].menus) {
                    modules[i].menus.sort((a, b) => {
                        if (a.name < b.name) return -1;
                    });
                }
            }

            state.user.data.modules = modules;
        }
    },
    modules: {}
});

export default store;