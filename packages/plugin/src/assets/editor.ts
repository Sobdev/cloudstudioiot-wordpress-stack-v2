/**
 * CloudStudio Elementor Widgets - Editor Scripts
 * 
 * Loaded in Elementor editor only.
 * Handles editor-specific functionality.
 */

import './styles/editor.css';

// Wait for Elementor to be ready
window.addEventListener('elementor/frontend/init', () => {
    console.log('CloudStudio Elementor Widgets v2.0.0 - Editor loaded');

    // Add custom editor behaviors here
    elementor.hooks.addAction('panel/open_editor/widget', (panel: any, model: any, view: any) => {
        const widgetType = model.get('widgetType');

        // Handle CloudStudio widgets
        if (widgetType?.startsWith('cloudstudio-')) {
            console.log(`Editing CloudStudio widget: ${widgetType}`);
        }
    });
});
