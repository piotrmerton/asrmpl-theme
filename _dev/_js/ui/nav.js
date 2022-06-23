import { UI } from '../ui';

export let nav = {

	//selectors
	headerSelector : '#header-top',
    navSelector : '.nav--top',
    buttonSelector : '.do-toggle-nav',

    //classes
    submenuClass: 'submenu__list',	
    hasSubmenuClass : 'item--has-submenu',
    openClass : 'menu--open',

    bind : function() {

		let header = document.querySelector(this.headerSelector);
        let nav = document.querySelector(this.navSelector);
        let button = document.querySelector(this.buttonSelector);

		/* 
		 *	1. bind menu UI button
		 */
		if(button === null) return;

		button.addEventListener('click', (event) => {
			this.toggleMenu();
			event.preventDefault();
		});        

		/* 
		 *	2. bind navigation links with different logic regarding submenu based
		 *	on current viewport width
		 */
		if(nav === null) return;

		let navLinks = nav.querySelectorAll('a');

		navLinks.forEach( (item) => {

            let li = item.parentNode;
			
			if( li.classList.contains(this.hasSubmenuClass) ) {

				//bind event to <a>
				item.addEventListener('click', (event) => {

					if( UI.windowWidth <= 960 ) {
						this.toggleSubmenu(li);											
                        event.preventDefault();
                        
					} else if ( UI.windowWidth > 960  ) {
						
						//on desktop toggle submenu only for highest level (not submenu)	
						if(!li.closest('ul').classList.contains(this.submenuClass)) {
							this.toggleSubmenu(li);
							event.preventDefault();
						}
					}
				});				

			}				

		});	     
		
		//close menu by clicking anywhere...
		document.addEventListener('click', (event) => {
			if( UI.mobile || UI.windowWidth < 960 ) return;
			this.resetMenu();
		});

		//...but not on header itself 
		header.addEventListener('click', (event) => {
			event.stopPropagation();
		});

    },

	/**
	 * toggle mobile menu
	 */
    toggleMenu : function() {

        let menu = document.querySelector(this.navSelector);
        let button = document.querySelector(this.buttonSelector);

        menu.classList.toggle(this.openClass);
        button.classList.toggle(this.openClass);

    },

	toggleSubmenu : function (el) {

		let parent = el.parentNode;
		let openClass = this.openClass;

		//select siblings based on current <li>
		let siblings = Array.prototype.filter.call(parent.children, function(child){
			return child !== el;
		});			

		//remove open class from siblings
		siblings.forEach( function(sibling) {
			sibling.classList.remove(openClass);
		});

        // toggle open class
        el.classList.toggle(openClass);
	

	},

	resetMenu : function() {

        let menu = document.querySelector(this.navSelector);
        let button = document.querySelector(this.buttonSelector);

        menu.classList.remove(this.openClass);
		button.classList.remove(this.openClass);
		
		let openMenuItems = menu.querySelectorAll('.'+this.openClass);

		openMenuItems.forEach( (item) => {
			item.classList.remove(this.openClass);
		});


	},


}