import React from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux'
import configureStore from 'store/configureStore'
import PodcastClipsRoot from 'containers/PodcastClipsRoot.jsx';

const store = configureStore()

render(
  <Provider store={store}>
    <PodcastClipsRoot />
  </Provider>,
  document.getElementById('podcast-clips-root'));
