/**
 * Config
 * -------------------------------------------------------------------------------------
 * ! IMPORTANT: Make sure you clear the browser local storage In order to see the config changes in the template.
 * ! To clear local storage: (https://www.leadshook.com/help/how-to-clear-local-storage-in-google-chrome-browser/).
 */

'use strict';

// JS global variables
window.config = {
  colors: {
    primary: '#b2366a',
    secondary: '#47285d',
    success: '#28c76f',
    info: '#00cfe8',
    warning: '#ff9f43',
    danger: '#ea5455',
    dark: '#4b4b4b',
    black: '#000',
    white: '#fff',
    cardColor: '#fff',
    bodyBg: '#f8f7fa',
    bodyColor: '#6f6b7d',
    headingColor: '#5d596c',
    textMuted: '#a5a3ae',
    borderColor: '#dbdade'
  },
  colors_label: {
    primary: '#b2366a',
    secondary: '#47285d',
    success: '#28c76f29',
    info: '#00cfe829',
    warning: '#ff9f4329',
    danger: '#ea545529',
    dark: '#4b4b4b29'
  },
  colors_dark: {
    cardColor: '#2f3349',
    bodyBg: '#25293c',
    bodyColor: '#b6bee3',
    headingColor: '#cfd3ec',
    textMuted: '#7983bb',
    borderColor: '#434968'
  },
  enableMenuLocalStorage: true // Enable menu state with local storage support
};

window.assetsPath = document.documentElement.getAttribute('data-assets-path');
window.baseUrl = document.documentElement.getAttribute('data-base-url') + '/';
window.templateName = document.documentElement.getAttribute('data-template');
window.rtlSupport = true; // set true for rtl support (rtl + ltr), false for ltr only.
