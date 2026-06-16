import axios from 'axios';

// Sanctum SPA auth: send cookies and the CSRF token with every request.
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = '/';

window.axios = axios;
