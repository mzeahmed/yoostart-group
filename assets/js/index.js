// Fichier de sortie des composant React

import GroupFeed from "./components/GroupFeed";

const {render, Component, useState} = wp.element;

render(
  <GroupFeed/>,
  document.getElementById('group-feed')
);
