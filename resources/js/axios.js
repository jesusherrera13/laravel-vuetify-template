import axios from "axios";
import store from "./store";


const axiosClient = axios.create({
    withCredentials: true,
    withXSRFToken: true,
    baseURL: import.meta.env.VITE_APP_API,
});


axiosClient.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;


    return config;
});


export default axiosClient;