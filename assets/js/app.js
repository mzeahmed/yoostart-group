import 'bootstrap/dist/js/bootstrap.bundle';
import './elements/Autogrow';

import GroupFeed from "./components/GroupFeed";

const {render, Component, useState} = wp.element;

render(
  <GroupFeed/>,
  document.getElementById('group-feed')
);