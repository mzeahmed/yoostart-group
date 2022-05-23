import 'bootstrap/dist/js/bootstrap';
import moment from 'moment/moment';
import 'popper.js/dist/popper';
import { render } from 'react-dom';
import App from './components/App';
import './elements/Autogrow';

moment.locale('fr');

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