import 'bootstrap/dist/js/bootstrap.bundle';
import './elements/Autogrow';
import App from './components/App';
import moment from 'moment/moment';

moment.locale('fr');

const { render, Component, useState } = wp.element;

render(
  <App/>,
  document.getElementById('group_posts')
);
