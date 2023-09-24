/**
 *
 */
import axios from "axios";
import store from "./store";
import router from "./router";

const axiosClient = axios.create({
  // baseURL: `${import.meta.env.VITE_API_BASE_URL}`
  baseURL: Base_URL
})

// axiosClient.interceptors.request.use(config => {
//   config.headers.Authorization = `Bearer ${store.state.user.token}`
//   return config;
// })
let token = document.head.querySelector('meta[name="csrf-token"]');
axiosClient.interceptors.request.use(config => {
  // config.headers.Authorization = `Bearer ${store.state.user.tokenn}`
    config.headers['X-CSRF-TOKEN'] = token.content;
    config.headers['X-Requested-With'] = 'XMLHttpRequest';

  return config;
})

// axiosClient.interceptors.response.use(response => {
//   return response;
// }, error => {
//   if (error.response.status === 401) {
//     sessionStorage.removeItem('TOKEN')
//     router.push({name: 'Login'})
//   } else if (error.response.status === 404) {
//     router.push({name: 'NotFound'})
//   }
//   throw error;
// })

export default axiosClient;
