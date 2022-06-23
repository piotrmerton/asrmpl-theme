import { UI } from './ui';
import { Render } from './render';

document.addEventListener("DOMContentLoaded", () => { 
    UI.init();
    UI.nav.bind();
    UI.form.bind(); 
    UI.search.bind(); 
    UI.tabs.bind();
    UI.video.init(); 
} );

window.addEventListener('resize', () => { UI.init() } );

/** 
 * Render React microfrontends components
 */
Render.calendar('#calendar', wp_core.rest.calendar);
Render.injuries('#injuries', wp_core.rest.injuries);
Render.posts('.posts-list', wp_core.rest.posts);
Render.videos('.video-list', wp_core.rest.videos);
Render.seriea('#serie-a');
Render.schedule('#schedule', wp_core.rest.schedule);
Render.playerstats('#player-stats', wp_core.rest.playerstats);
Render.shoutbox('#shoutbox', wp_core.rest.shoutbox);