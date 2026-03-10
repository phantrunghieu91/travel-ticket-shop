document.addEventListener('DOMContentLoaded', function() {
  const tabsController = {
    init() {
      try {
        this.cacheElements();
        this.bindEvents();
      } catch( error ) {
        console.warn('TABS ERROR: ', error);
      }
    },
    cacheElements() {
      this.tabs = document.querySelectorAll('.tabs');
      if( !this.tabs.length ) throw new Error('No tabs found');
    },
    bindEvents() {
      this.tabs.forEach( tabs => {
        const tabNavItems = [...tabs.querySelectorAll('.tabs__nav-item')];
        const tabPanels = [...tabs.querySelectorAll('.tabs__panel')].reduce( (acc, panel) => {
          const panelId = panel.getAttribute('id');
          if( !panelId ) throw new Error('Tab panel missing id attribute');
          acc[panelId] = panel;
          return acc;
        }, {} );
        if( !tabNavItems.length ) throw new Error('No tab nav items found');
        tabNavItems.forEach( (item, index) => {
          const panelId = item.getAttribute('aria-controls');
          if( !panelId ) throw new Error('Tab nav item missing aria-controls attribute');
          const targetPanel = tabPanels[panelId];
          if( !targetPanel ) throw new Error(`No tab panel found with id: ${panelId}`);
          item.addEventListener('click', () => {
            if( item.getAttribute('aria-selected') === 'true' ) return;
            tabNavItems.forEach( nav => {
              nav.setAttribute('aria-selected', 'false');
            } );
            Object.values(tabPanels).forEach( panel => {
              panel.setAttribute('aria-hidden', 'true');
            });
            item.setAttribute('aria-selected', 'true');
            targetPanel.setAttribute('aria-hidden', 'false');
          });
        });
      } );
    }
  }.init();
});