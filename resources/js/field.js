Nova.booting((Vue, router, store) => {
  Vue.component('index-images', require('./components/IndexField'))
  Vue.component('detail-images', require('./components/DetailField'))
  Vue.component('form-images', require('./components/FormField'))
})
