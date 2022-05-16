import 'bootstrap/dist/js/bootstrap.bundle';
import moment from 'moment/moment';
import './elements/Autogrow';
import App from './components/App';

moment.locale('fr');

const { render } = wp.element;

render(
  <App/>,
  document.getElementById('group_posts')
);

/** test */
// fetch('https://yoostart.com.local/wp-json/jwt-auth/v1/token', {
//  method: 'POST',
//  headers: {
//    'Content-Type': 'application/json',
//    'accept': 'application/json'
//  },
//
//  body: JSON.stringify({
//    'username': 'ahmed',
//    'password': '_Mesfilssontnes1'
//  })
//})
//  .then((response) => {
//    return response.json();
//  })
//  .then((user) => {
//    console.log(user.token);
//    // localStorage.setItem('jwt', user.token);
//  });