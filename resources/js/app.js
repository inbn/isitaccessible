require('./bootstrap');

/**
 * If browser back button was used, flush cache
 * This ensures that user will always see an accurate, up-to-date view based on their state
 * https://stackoverflow.com/questions/8788802/prevent-safari-loading-from-cache-when-back-button-is-clicked
 *
 * This resolves an issue in Firefox where the search would not work when after the back button
 */
(function () {
  window.onpageshow = function(event) {
    if (window.performance) {
      var navEntries = window.performance.getEntriesByType('navigation');
      // Detect if browser back button was clicked
      if (navEntries.length > 0 && navEntries[0].type === 'back_forward' && event.persisted) {
        window.location.reload();
      }
    }
  };
})();
