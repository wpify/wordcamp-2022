import React from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';

const App = () => {
  return (
    <div className="some-react-app">
      <h1>{__('Here is some app', 'wordcampprague')}</h1>
    </div>
  );
};

document.addEventListener('DOMContentLoaded', function () {
  const items = document.querySelectorAll('[data-app="wordcamp"]');
  if (items) {
    items.forEach((item) => ReactDOM.render(<App/>, item));
  }
});

