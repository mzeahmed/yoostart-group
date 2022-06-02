import 'bootstrap/dist/js/bootstrap';
import moment from 'moment';
import 'popper.js/dist/popper';
import { createApp } from 'vue';
import './js/elements/Autogrow';
import App from './vue/App';

moment.locale('fr');

createApp(App).mount('#group_posts');
