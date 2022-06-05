import moment from 'moment';
import { createApp } from 'vue';
import './js/elements/Autogrow';
import App from './vue/App';
// import bulmaModal from './js/modules/bulmaModal';
//
// bulmaModal();
moment.locale('fr');

createApp(App).mount('#group_posts');
