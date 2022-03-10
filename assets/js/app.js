import 'bootstrap/dist/js/bootstrap.bundle';
import './elements/Autogrow';
import fileUploadHandler from "./modules/groups-manage";
import GroupFeed from "./components/GroupFeed";

// fileUploadHandler();

const {render, Component, useState} = wp.element;

render(
  <GroupFeed/>,
  document.getElementById('group-feed')
);
