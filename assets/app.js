import moment from 'moment';
import { createApp } from 'vue';
import './js/elements/Autogrow';
import App from './vue/App';

moment.locale('fr');

createApp(App).mount('#group_posts');
