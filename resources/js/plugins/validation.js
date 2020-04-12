import '../mixins/ValidationMixin';

export default (store) => {
  window.axios.interceptors.request.use((config) => {
    store.dispatch('validation/clearErrors');
    return config;
  });

  window.axios.interceptors.response.use(response => response, error => {
    if (error.response.status === 422) {
      store.dispatch('validation/setErrors', error.response.data.errors)
    }

    return Promise.reject(error);
  });
}
