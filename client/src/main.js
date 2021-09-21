import {createApp} from 'vue'
import App from './App.vue'
import router from "./router";

import axios from 'axios'

window.axios = axios
axios.defaults.baseURL = 'http://localhost/softzino/api/api';
// axios.defaults.headers = {
//     'Access-Control-Allow-Origin':"*",
//     'Access-Control-Allow-Credentials':"true",
//     'Access-Control-Allow-Methods':"GET,HEAD,OPTIONS,POST,PUT",
//     'Access-Control-Allow-Headers':"Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, app-key, app-secret",
//     'app-key': "SOFTZINO",
//     'app-secret': "base64:CXJ9JiHEr53jVenUWitEIhvZh4fiMEBTb9rjvVk2dS0="
//
// }

// createApp(App).use(router).mount('#app');
createApp(App).use(router).mount('#app')
