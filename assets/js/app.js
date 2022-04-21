import 'bootstrap/dist/js/bootstrap.bundle';
import './elements/Autogrow';
import GroupFeed from './components/GroupFeed';

// fileUploadHandler();

let groups = document.querySelector('#ys_groups');
let url = groups.dataset.request;

console.log(groups);
console.log(url);

fetch(url, {
  method: 'GET'

}).then((response) => response.json())
  .then((data) => {
    console.log(data);
  }).catch((e) => console.log(e));

const { render, Component, useState } = wp.element;

render(
  <GroupFeed/>,
  document.getElementById('group-feed')
);
