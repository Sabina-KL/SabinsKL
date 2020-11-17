window.Vue = require('vue');

//Import v-from
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//component
Vue.component('form-component', require('../components/formComponent.vue').default);

const app = new Vue({
    el: '#form-app',
});