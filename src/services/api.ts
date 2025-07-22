import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Add token to requests if available
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Handle token expiration
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token');
      localStorage.removeItem('currentUser');
      window.location.href = '/';
    }
    return Promise.reject(error);
  }
);

export const authAPI = {
  login: (email: string, password: string) =>
    api.post('/login', { email, password }),
  logout: () => api.post('/logout'),
  me: () => api.get('/me'),
};

export const studentsAPI = {
  getAll: () => api.get('/students'),
  create: (data: any) => api.post('/students', data),
  update: (id: number, data: any) => api.put(`/students/${id}`, data),
  delete: (id: number) => api.delete(`/students/${id}`),
  getById: (id: number) => api.get(`/students/${id}`),
};

export const professorsAPI = {
  getAll: () => api.get('/professors'),
  create: (data: any) => api.post('/professors', data),
  update: (id: number, data: any) => api.put(`/professors/${id}`, data),
  delete: (id: number) => api.delete(`/professors/${id}`),
  getById: (id: number) => api.get(`/professors/${id}`),
};

export const coursesAPI = {
  getAll: () => api.get('/courses'),
  create: (data: any) => api.post('/courses', data),
  update: (id: number, data: any) => api.put(`/courses/${id}`, data),
  delete: (id: number) => api.delete(`/courses/${id}`),
  getById: (id: number) => api.get(`/courses/${id}`),
};

export const eventsAPI = {
  getAll: () => api.get('/events'),
  create: (data: any) => api.post('/events', data),
  update: (id: number, data: any) => api.put(`/events/${id}`, data),
  delete: (id: number) => api.delete(`/events/${id}`),
  getById: (id: number) => api.get(`/events/${id}`),
};

export const certificatesAPI = {
  getAll: () => api.get('/certificates'),
  create: (data: any) => api.post('/certificates', data),
  update: (id: number, data: any) => api.put(`/certificates/${id}`, data),
  delete: (id: number) => api.delete(`/certificates/${id}`),
  getById: (id: number) => api.get(`/certificates/${id}`),
};

export default api;